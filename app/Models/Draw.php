<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Battlefloor;
use App\Models\Square;
use App\Models\Line;
use App\Models\Icon;

class Draw extends Model
{
    public Static $types = [
        'Square',
        'Line',
        'Icon'
    ];

    protected $fillable = [
        // Fkeys
        "battlefloor_id", 
        "drawable_id", 
        "drawable_type"
    ];

    /**
     * Relationships
     */
    public function battlefloor()
    {
        return $this->belongsTo(Battlefloor::class);
    }

    /**
     * Morphs
     */
    public function drawable()
    {
        return $this->morphTo();
    }

    /**
     * Create override function (Default Model create method)
     */
    public static function create(array $attributes = [])
    {
        // Invalid Type
        if(!in_array($attributes['type'], Self::$types)){
            abort(400, "Invalid Type of draw {$attributes['type']}");
        }
        
        $drawable = call_user_func_array(__NAMESPACE__ . '\\' . $attributes['type'] . "::create" , [$attributes]);
        $attributes["drawable_type"] = get_class($drawable);
        $attributes["drawable_id"] = $drawable->id;
        
        return static::query()->create($attributes);
    }
}
