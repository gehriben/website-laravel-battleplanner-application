<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    protected $fillable = [
        "battlefloor_id", 
        "originX",
        "originY", 
        "destinationX",
        "destinationY", 
        "user_id", 
        "saved",
        "drawable_id", 
        "drawable_type", 
        "deleted"
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function battlefloor()
    {
        return $this->belongsTo('App\Models\Battlefloor');
    }

    /**
     * public Methods
     */
    
     /**
      * TODO: Refactor to use laravel softDelete trait
      */
     public function restore(){
        $this->deleted = false;
        $this->save();
     }

     /**
      * TODO: Refactor to use laravel softDelete trait
      */
     public function setDeleted(){
        $this->deleted = true;
        $this->save();
     }

    /**
     * Morphs
     */
    public function drawable()
    {
        return $this->morphTo();
    }

    /**
     * Scopes
     */
    public function scopeCopiable($query){
        return $query
            ->where('deleted', false)
            ->where('saved', true);
    }
    
    public function scopeNotDeleted($query)
    {
        return $query->where('deleted', '=', false);
    }

}
