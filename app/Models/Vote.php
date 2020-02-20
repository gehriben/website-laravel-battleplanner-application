<?php

namespace App\Models;

use App\Models\OperatorSlot;
use App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'value', 'user_id', "battleplan_id"
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function battleplan()
    {
        return $this->belongsTo('App\Models\Battleplan');
    }

    /**
     * Searches
     */
    public static function search($userId,$battleplanId){
        return Vote::where("user_id", $userId)
            ->where("battleplan_id", $battleplanId)
            ->first();
    }

    /**
     * Model overrides
     */

    /**
     * Check if user has already voted for the battle plan
     * Required Attributes ["user_id","battleplan_id","value"]
     */
    public static function create(array $attributes = [])
    {
        // Cannot divide by 0
        if($attributes['value'] == 0){
            throw new \Exception('Cannot divide by 0');
        }

        // Find pre-existing vote
        $vote = Vote::search($attributes['user_id'],$attributes['battleplan_id']);

        // Modify existing vote
        if( $vote){
            $vote->value = $attributes['value'];
            $vote->save();
            return $vote;
        }

        // Make new instance
        return static::query()->create($attributes);
    }
    
}
