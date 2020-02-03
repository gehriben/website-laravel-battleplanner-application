<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Square extends Model
{
    protected $fillable = [
        "color", "lineSize"
    ];

    /**
     * Morph Drawable
     */
    public function Drawable()
    {
        return $this->morphOne('App\Models\Draw', 'drawable');
    }
}
