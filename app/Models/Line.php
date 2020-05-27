<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Coordinate;

class Line extends Model
{
    protected $fillable = [
        // Properties
        "color", "size"
    ];

    /**
     * Morph Drawable
     */
    public function drawable()
    {
        return $this->morphOne(Draw::class, 'drawable');
    }
    
    /**
     * Relationships
     */
    public function coordinates()
    {
        return $this->belongsToMany(Coordinate::class);
    }

    /**
     * Create override function (Default Model create method)
     */
    public static function create(array $attributes = [])
    {
        
        // we need to optimize the compressions of objects or else we go over the alloted php POST size limit.
        // Serialization is a 2n array where all 1n are x and 2n are y coordinates
        $explodedPoints = explode(',', $attributes['points']);

        $points = [];
        for ($i=0; $i < count($explodedPoints); $i++) {
            $points[] = Coordinate::create(['x' => $explodedPoints[$i], 'y' => $explodedPoints[++$i]]);
        }
        
        $model = static::query()->create($attributes);

        $model->coordinates()->sync(array_column($points, 'id'));

        return $model;
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['points'] = $this->coordinates;
        return $array;
    }
}
