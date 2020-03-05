<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\User\User;
use Carbon\Carbon;

// Events
use App\Events\MediaDeleting;

/**
 * Media manager model synced to AWS s3 bucket
 * 
 * IMPORTANT: This model has a registered delete event listener inside 
 */
class Media extends Model
{

    protected const FORBIDEN_FILE_TYPES = ['exe'];
    protected const S3_PATH = "/uploads/";
    protected const DEFAULT_NAME_LENGTH = 12;

    // DB Table
    protected $table = "medias";

    /**
     * Event listeners
     * (Allows you to inject code when an event is fired)
     */
    protected $dispatchesEvents = [
        'deleting' => MediaDeleting::class, // delete S3 file on record deletion
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTypeAttribute(){
        $exploded = explode(".", $this->path);
        return $exploded[count($exploded)-1];
    }
    /**
     * Create override function (Default Model create method)
     * Required attributed ['content','name', 'type', 'visibility', 'user_id']
     * @return Media|\Exception
     */
    public static function create(array $attributes = [])
    {
        // invalid file type
        if (in_array($attributes["type"], SELF::FORBIDEN_FILE_TYPES)) {
            throw new \Exception("Invalid file type : $type");
        }

        // Upload to S3
        try {
            $path = self::upload(self::generateName(), $attributes["type"], $attributes["content"], $attributes["visibility"]);    
        } 
        
        // There was an error uploading the file
        catch (\Throwable $th) {
            throw $th;
        }

        // Create our database record
        return static::query()->create([
            'name' => $attributes["name"],
            'path'=> $path,
            'user_id' => $attributes["user_id"]
        ]);
    }


    /**
     * Override the delete function in order to remove the asset stored on S3 alongiste the DB entry
     */
    public function delete()
    {
        $this->remove(); // delete from s3
        parent::delete(); // delete db entry
    }

    /**
     * S3 functions
     */
    
    /**
     * Upload file to s3 bucket
     * @return \Exception|String
     */
    public static function upload($name,$type,$content, $visibility = 'private'){
        // Variable declarations
        $validVisibilities = ['private', 'public'];

        // Invalid visibility parameter
        if(!in_array($visibility,$validVisibilities)){
            throw new \Exception("Invalid file visibility '$visibility' ");
        }

        // Attempt to upload via S3 API
        try{
            $filePath = self::S3_PATH . $name . "." . $type;
            $success = Storage::disk('s3')->put($filePath, $content, $visibility);
        }

        // S3 upload had an error
        catch(Exception $e) {
            throw $e;
        }

        // upload successfull, return storage path for public usage
        return $filePath;
    }

    /**
     * Remove files from S3
     * @return \Exception|String
     */
    public function remove(){

        if(Storage::disk('s3')->exists($this->path)){
            Storage::disk('s3')->delete($this->path);
        }

        return true;
    }

    /**
     * Retrieve signed url for file on S3
     * @return \Exception|String
     */
    public function url()
    {
        // Get s3 client
        $s3 = $this->s3();

        // retrieve command
        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => env('AWS_BUCKET') ?: die('No "AWS_BUCKET" config var in found in env!'),
            'Key' => str_replace("/u", "u", $this->path)
        ]);

        // Presigned URL set to expire after 60 minutes.
        $request = $s3->createPresignedRequest($cmd, '+60 minutes');
        return (string) $request->getUri();
    }

    /**
     * Generate unique file name for our storage
     */
    public static function generateName($length = null){
        // Empty Length
        if(!$length){
            $length = self::DEFAULT_NAME_LENGTH;
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = "";    
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[rand(0,strlen($characters)-1)];
        }
        return $string . "-" . str_replace([":"," "], "-", Carbon::now());
    }

    /**
     * Generate s3 client
     */
    private function s3(){
        // Instructions found here: https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/s3-presigned-url.html
        return new S3Client([
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY')
            ],
            'version'  => 'latest',
            'region'   => env('AWS_DEFAULT_REGION'),
        ]);
    }

    /**
     * Printing override
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['url'] = $this->url();
        return $array;
    }

    /**
     * Custom constructor from a file
     */
    public static function fromFile($file, $userId, $visibility = 'private'){
        $extention = $file->extension();
        $name = preg_replace("/\.$extention$/","",$file->getClientOriginalName());
        return Media::create([
            'content' => file_get_contents($file),
            'name' => $name,
            'type' => $file->extension(),
            'visibility' => $visibility,
            'user_id' => $userId
        ]);

    }
}