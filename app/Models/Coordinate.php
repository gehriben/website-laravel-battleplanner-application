<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Coordinates;

class Coordinate extends Model
{
    protected $fillable = [
        // Properties
        'x', 
        'y'
    ];
}
