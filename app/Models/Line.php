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
        $points = [];
        foreach ($attributes['points'] as $key => $point) {
            $points[] = Coordinate::create($point);
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
