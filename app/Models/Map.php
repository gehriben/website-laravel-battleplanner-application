<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
  
  protected $fillable = [
    'name', 'media_id', 'is_competitive',
  ];

  /**
   * Relationships
   */
  
  public function thumbnail() {
    return $this->belongsTo(Media::class, 'media_id');
  }

  public function floors() {
    return $this->hasMany('App\Models\Floor', 'map_id');
  }

  public function battleplans() {
    return $this->hasMany('App\Models\Battleplan');
  }

  /**
   * Searches
   */
  public static function byName($name){
      return Map::where("name", $name)->first();
  }

  /**
   * Create override function (Default Model create method)
   */
  public static function create(array $attributes = [])
  {
      $media = Media::fromFile($attributes['thumbnail'], "maps/{$attributes['name']}", "public");
      $attributes['media_id'] = $media->id;
      return static::query()->create($attributes);
  }
}
