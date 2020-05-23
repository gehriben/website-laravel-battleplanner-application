<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Line;

// Model
use App\Models\Floor;
use App\Models\Battleplan;
use App\Models\Draw;

class Battlefloor extends Model
{
    public $timestamps = true;
    
    protected $fillable = [
        // Fkeys
        'battleplan_id', 'floor_id'
    ];

    /**
     * Relationships
     */
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function battleplan()
    {
        return $this->belongsTo(Battlefloor::class);
    }

    public function draws()
    {
        return $this->hasMany(Draw::class);
    }

}
