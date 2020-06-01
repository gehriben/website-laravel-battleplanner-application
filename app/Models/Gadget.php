<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Operator;
use App\Models\Media;

class Gadget extends Model
{
  use SoftDeletes;

  public static function boot() {
    parent::boot();

    static::deleting(function($gadget) {
         DB::table('operator_gadget')->where('gadget_id', $gadget->id)->delete();
    });
  }

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
    return $this->belongsToMany(Operator::class, 'operator_gadget');
  }

  public function icon() {
    return $this->belongsTo(Media::class);
  }

  public static function create(array $attributes = []) {
    // $media = Media::fromFile($attributes['icon'], "gadgets/{$attributes['name']}", "public");
    // $attributes['icon_id'] = $media->id;
    return static::query()->create($attributes);
  }
}
