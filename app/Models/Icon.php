<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Draw;
use App\Models\Coordinates;

class Icon extends Model
{
    protected $fillable = [
        // Fkeys
        "source_id", "origin_id", "destination_id"
    ];
    
    /**
     * Relationships
     */
    
    public function source() {
        return $this->belongsTo(Media::class);
    }

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
