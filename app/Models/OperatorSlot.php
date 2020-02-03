<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Operator;

class OperatorSlot extends Model
{
   protected $fillable = [
     'operator_id', 'battleplan_id'
   ];

  /**
   * Relationships
   */
  public function battleplan() {
    return $this->belongsTo('App\Models\Battleplan');
  }

  public function operator() {
    return $this->belongsTo('App\Models\Operator');
  }

  /**
   * Public Methods
   */

  /**
   * Set the operator in the slot
   */
  public function setOperator($operatorId){
      $this->update(["operator_id" => $operatorId]);
  }

  /**
   * Copy the object
   * TODO: Refactor according to Battleplan logic refactor
   */
  public function copy($slot){
    $fields = $slot->toArray();

    unset($fields["id"]);
    unset($fields["battleplan_id"]);
    
    // replicate slot
    $this->fill($fields);
    $this->save();

  }
}
