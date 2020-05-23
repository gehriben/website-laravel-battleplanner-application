<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Operator;
use App\Models\Battleplan;

class OperatorSlot extends Model
{
   protected $fillable = [
     // Fkeys
     'operator_id', 'battleplan_id'
   ];

  /**
   * Relationships
   */
  public function battleplan() {
    return $this->belongsTo(Battleplan::class);
  }

  public function operator() {
    return $this->belongsTo(Operator::class);
  }
}
