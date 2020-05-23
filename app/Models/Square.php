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
        "color", "size",
        
        // Fkeys
        "origin_id", "destination_id"
    ];
    
    /**
     * Relationships
     */
    public function origin()
    {
        return $this->belongsTo(Coordinates::class);
    }

    public function destination()
    {
        return $this->belongsTo(Coordinates::class);
    }

    /**
     * Morph Drawable
     */
    public function Drawable()
    {
        return $this->morphOne(Draw::class, 'drawable');
    }
}
