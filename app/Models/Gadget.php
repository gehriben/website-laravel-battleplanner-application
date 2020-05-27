<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Operator;
use App\Models\Media;

class Gadget extends Model
{
  protected $fillable = [
    // Properties
    'name',

    // Fkeys
    'icon_id',
  ];

  /**
   * Relationships
   */
  public function operators() {
    return $this->belongsToMany(Operator::class);
  }

  public function icon() {
    return $this->belongsTo(Media::class);
  }

  public static function create(array $attributes = []) {
    $media = Media::fromFile($attributes['icon'], "gadgets/{$attributes['name']}", "public");
    $attributes['icon_id'] = $media->id;
    return static::query()->create($attributes);
  }
}
