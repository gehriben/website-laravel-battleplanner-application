<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\User;
use App\Models\Battleplan;

class Room extends Model
{
  protected $fillable = [
    'owner', 'connection_string', 'battleplan_id'
  ];

  /**
   * Relationships
   */
  public function Owner() {
    return $this->belongsTo(User::class, 'owner');
  }

  public function Battleplan() {
    return $this->belongsTo(Battleplan::class);
  }

  /**
   * Searches
   */
  public static function Connect($conn_string) {
    return Room::where('connection_string', $conn_string)->first();
  }

  /**
   * Public Static methods
   */
  public static function generateConnectionString(){
    return uniqid();
  }
}
