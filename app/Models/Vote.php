<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\User;
use App\Models\Battleplan;

class Vote extends Model
{
    protected $fillable = [
        // Properties
        'value', 
        
        // Fkeys
        'user_id', "battleplan_id"
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function battleplan()
    {
        return $this->belongsTo(Battleplan::class);
    }

    /**
     * Scopes
     */
    public static function ScopeAlreadyVoted($query, $userId,$battleplanId){
        return $query->where("user_id", $userId)
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
        $vote = Vote::AlreadyVoted($attributes['user_id'],$attributes['battleplan_id']);

        // Modify existing vote
        if($vote){
            $vote->value = $attributes['value'];
            $vote->save();
            return $vote;
        }

        // Make new instance
        return static::query()->create($attributes);
    }
    
}
