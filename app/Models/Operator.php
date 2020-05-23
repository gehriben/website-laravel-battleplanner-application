<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Gadget;
use App\Models\OperatorSlot;
use App\Models\Media;

class Operator extends Model
{
  protected $fillable = [
    // Properties
    'name', 'colour', 'attacker',

    // Fkey
    'icon_id'
  ];

  /**
   * Relationships
   */
  
  public function icon() {
    return $this->belongsTo(Media::class);
  }

  public function gadgets() {
    return $this->belongsToMany(Gadget::class);
  }

  public function slots() {
    return $this->belongsToMany(OperatorSlot::class);
  }

  /**
   * Scopes
   */
  public static function scopeAttackers($scope) {
    return $scope->where("attacker", true);
  }

  public static function scopeDefenders($scope) {
    return $scope->where("attacker", false);
  }
}
