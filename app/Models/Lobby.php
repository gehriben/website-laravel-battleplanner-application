<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lobby extends Model
{
    protected $fillable = [
        // Properties
        'connection_string',

        // Fkeys
        "owner_id",
    ];

    /**
     * Relationships
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Scope
     */
    public static function scopeByConnection($query, $conn_string) {
        return $query->where('connection_string', $conn_string);
    }

    /**
     * Create override function (Default Model create method)
     */
    public static function create(array $attributes = [])
    {
        $attributes["connection_string"] = uniqid();   
        return static::query()->create($attributes);
    }

}
