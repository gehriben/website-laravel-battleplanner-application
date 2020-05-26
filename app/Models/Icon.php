<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Draw;
use App\Models\Coordinates;

class Icon extends Model
{
    protected $fillable = [
        // Properties
        "source", "size",

        // Fkeys
        "origin_id"
    ];
    
    /**
     * Relationships
     */
    public function origin()
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

        $model = static::query()->create($attributes);

        return $model;
    }
    
    public function toArray()
    {
        // dd($this->origin);
        $array = parent::toArray();
        $array['source'] = $this->source;
        $array['origin'] = $this->origin;
        return $array;
    }
}
