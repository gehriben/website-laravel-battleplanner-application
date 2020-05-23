<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Map;
use App\Models\Media;
use App\Models\Floor;
use App\Models\Battlefloor;

class Floor extends Model
{
  public $timestamps = true;

  protected $fillable = [
    // Properties
    'name', 'order',

    // Fkeys
    'map_id', 'source_id'
  ];

  /**
   * Relationships
   */
  public function map() {
    return $this->belongsTo(Map::class);
  }

  public function source() {
    return $this->belongsTo(Media::class);
  }

  public function battlefloors() {
    return $this->hasMany(Battlefloor::class);
  }

   /**
     * Create override function (Default Model create method)
     */
    public static function create(array $attributes = []) {
        $map = Map::find($attributes["map_id"]);
        $media = isset($attributes['source']) ? Media::fromFile($attributes['source'], "maps/" . $map->name, "public") : null;
        $attributes['source_id'] = ($media) ? $media->id : null;
        return static::query()->create($attributes);
    }
}
