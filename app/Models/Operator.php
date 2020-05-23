<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class Operator extends Model
{
  protected $fillable = [
    'name', 'media_id', 'colour', 'atk'
  ];

  /**
   * Relationships
   */
  public function battleplan() {
    return $this->belongsToMany('App\Models\Battleplan');
  }

  public function gadgets() {
    return $this->belongsToMany('App\Models\Gadget');
  }

  public function slots() {
    return $this->belongsToMany('App\Models\OperatorSlot');
  }

  public function media() {
    return $this->belongsTo(Media::class, 'media_id');
  }

  public static function create(array $attributes = []) {
    $media = Media::fromFile($attributes['icon'], "operators/{$attributes['name']}", "public");
    $attributes['media_id'] = $media->id;
    return static::query()->create($attributes);
  }

  /**
   * Searches
   */
  public static function attackers() {
    return Operator::where("atk", true)->get();
  }

  public static function defenders() {
    return Operator::where("atk", false)->get();
  }
}
