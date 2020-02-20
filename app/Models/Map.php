<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
  protected $fillable = [
    'name', 'thumb_path', 'comp', 'battleplan_id',
  ];

  /**
   * Relationships
   */
  public function floors() {
    return $this->hasMany('App\Models\Floor', 'map_id');
  }

  public function battleplan() {
    return $this->hasMany('App\Models\Battleplan');
  }

  /**
   * Searches
   */
  public static function byName($name){
      return Map::where("name", $name)->first();
  }
}
