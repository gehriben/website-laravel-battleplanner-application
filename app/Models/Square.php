<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Coordinates;
use App\Models\Draw;

class Square extends Model
{
    protected $fillable = [
        // Properties
        "color", "size", 'opacity',
        
        // Fkeys
        "origin_id", "destination_id"
    ];
    
    /**
     * Relationships
     */
    public function origin()
    {
        return $this->belongsTo(Coordinate::class);
    }

    public function destination()
    {
        return $this->belongsTo(Coordinate::class);
    }

    /**
     * Morph Drawable
     */
    public function Drawable()
    {
        return $this->morphOne(Draw::class, 'drawable');
    }

    public static function create(array $attributes = [])
    {
        $attributes['origin_id'] = Coordinate::create($attributes["origin"])->id;
        $attributes['destination_id'] = Coordinate::create($attributes["destination"])->id;

        $model = static::query()->create($attributes);

        return $model;
    }
    
    public function toArray()
    {
        $array = parent::toArray();
        $array['origin'] = $this->origin;
        $array['destination'] = $this->destination;
        return $array;
    }
}
