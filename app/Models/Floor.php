<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class Floor extends Model
{
  public $timestamps = true;

  protected $fillable = [
    'name', 'media_id', 'order', 'map_id',
  ];

  /**
   * Relationships
   */
  public function map() {
    return $this->belongsTo('App\Models\Map', 'map_id', 'id');
  }

  public function media() {
    return $this->belongsTo(Media::class);
  }

  public function battlefloors() {
    return $this->hasMany('App\Models\Battlefloor');
  }

   /**
     * Create override function (Default Model create method)
     */
    public static function create(array $attributes = []) {
        $map = Map::find($attributes["map_id"]);
        $media = isset($attributes['file']) ? Media::fromFile($attributes['file'], "maps/" . $map->name, "public") : null;
        $attributes['media_id'] = ($media) ? $media->id : null;
        return static::query()->create($attributes);
    }
}
