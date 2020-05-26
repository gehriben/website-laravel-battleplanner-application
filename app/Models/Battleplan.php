<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\User;
use App\Models\OperatorSlot;
use App\Models\Map;
use App\Models\Vote;
use App\Models\Battlefloor;

class Battleplan extends Model
{
    /**
     * Model Settings
     */
    public $timestamps = true;
    const OPERATOR_SLOTS = 5;
    const DEFAULT_NAME = 'Untitled';
    const DEFAULT_DESCRIPTION = '';
    const DEFAULT_NOTES = '';

    /**
     * Editable variables
     */
    protected $fillable = [
        // Properties
        'name', 'description', 'saved', 'notes', 'public',

        // Fkeys
        'owner_id', 'map_id', 
    ];
    
    public Static $printWith = [
        'owner',
        'battlefloors',
        'battlefloors.floor',
        'battlefloors.floor.source',
        'battlefloors.draws',
        'battlefloors.draws.drawable',
        'operatorSlots',
        'operatorSlots.operator',
        'operatorSlots.operator.icon',
    ];
    
    /**
     * Relationships
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function map()
    {
        return $this->belongsTo(Map::class);
    }

    public function battlefloors()
    {
        return $this->hasMany(Battlefloor::class);
    }

    public function operatorSlots()
    {
        return $this->hasMany(OperatorSlot::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Create new plan
     * Required ["map_id","notes","public"]  
     */
    public static function create(array $attributes = [])
    {        
        // Defaults
        $attributes["name"] = isset($attributes["name"]) ? $attributes["name"] : self::DEFAULT_NAME;
        $attributes["description"] = isset($attributes["description"]) ? $attributes["description"] : self::DEFAULT_DESCRIPTION;
        $attributes["notes"] = isset($attributes["notes"]) ? $attributes["notes"] : self::DEFAULT_NOTES;

        // Parent Create method
        $battleplan = static::query()->create($attributes);

        $battleplan->createSlots(self::OPERATOR_SLOTS);
        $battleplan->createFloors();

        return $battleplan;
    }

    /**
     * Create the porper number of operator slots for this battleplan
     */
    private function createSlots($quantity){
        $compiled = [];
        for ($i=0; $i < $quantity; $i++) {
            $compiled[] = OperatorSlot::create(["battleplan_id" => $this->id]);
        }
        return $compiled;
    }

    /**
     * Create the battle floors for the battleplan
     */
    private function createFloors(){
        $compiled = [];
        foreach ($this->map->floors as $key => $floor) {
            $compiled[] = Battlefloor::create([
                "floor_id" => $floor->id,
                "battleplan_id" => $this->id,
            ]);
        }
        return $compiled;
    }
}
