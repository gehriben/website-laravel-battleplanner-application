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
}
