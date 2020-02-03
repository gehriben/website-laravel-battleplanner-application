<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
  protected $fillable = [
    'owner', 'connection_string', 'battleplan_id'
  ];

  /**
   * Relationships
   */
  public function Owner() {
    return $this->hasOne('App\Models\User', 'id', 'owner');
  }

  public function Battleplan() {
    return $this->belongsTo('App\Models\Battleplan');
  }

  /**
   * Searches
   */
  public static function Connect($conn_string) {
    return Room::where('connection_string', $conn_string)->first();
  }
}
