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
        return $this->hasMany(Coordinate::class);
    }
}
