<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Battlefloor;

class Draw extends Model
{
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
}
