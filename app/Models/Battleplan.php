<?php

namespace App\Models;

use App\Models\OperatorSlot;
use App\Models\Map;
use App\Models\Vote;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Battleplan extends Model
{
    /**
     * Model Settings
     */
    const OPERATOR_SLOTS = 5;
    const DEFAULT_NAME = 'Untitled';
    const DEFAULT_DESCRIPTION = '';
    const DEFAULT_NOTES = '';
    public $timestamps = true;

    /**
     * Editable variables
     */
    protected $fillable = [
        'name', 'description', 'owner_id', 'gametype_id', 'map_id', 'saved', 'notes', "public"
    ];
    
    /**
     * Relationships
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function map()
    {
        return $this->belongsTo('App\Models\Map');
    }

    public function battlefloors()
    {
        return $this->hasMany('App\Models\Battlefloor');
    }

    public function gametype()
    {
        return $this->belongsTo('App\Models\Gametype');
    }

    public function operatorSlots()
    {
        return $this->hasMany('App\Models\OperatorSlot');
    }

    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }

    /**
     * TODO: Optimize with sql instead of for loop
     * Tally the sum of votes for the battleplan
     */
    public function voteTally(){
        $sum = 0;
        foreach ($this->votes as $key => $vote) {
            $sum += $vote->value;
        }
        return $sum;
    }

    /**
     * Scopes
     */

     /**
      * Find publicly available plans
      */
    public function scopePublic($query)
    {
        return $query->where('saved', true);
    }

    public function scopeSlotData($query){
        $query
            ->with("operatorSlots")
            ->with("operatorSlots.operator");
    }

    public function scopeMapData($query){
        $query
            ->with("map")
            ->with("map.floors");
    }

    public function scopeBattlefloorData($query){
        $query
            ->with("battlefloors")
            ->with("battlefloors.floor")
            ->with(['battlefloors.draws' => function ($q) {
                    $q
                        ->notDeleted()
                        ->with("drawable");
                }]);
    }
    
    /**
     * Copy Constructor
     * TODO: Refactor
     */
    public static function copy($battleplan, $user, $name){
        // replicate battleplan
        $newBattleplan = Battleplan::create([
            'map_id' => $battleplan->map->id,
            'owner' => $user->id,
            'name' => $name,
            'description' => $battleplan->description,
            'notes' => $battleplan->notes,
            'saved' => "1"
        ]);
        
        // replicate floors
        foreach ($newBattleplan->battlefloors as $key => $newFloor) {
            $oldFloor = $battleplan->battlefloors[$key];
            $newFloor->copy($oldFloor);
        }

        // replicate Slots
        foreach ($newBattleplan->slots as $key => $newSlot) {
            $oldSlot = $battleplan->slots[$key];
            $newSlot->copy($oldSlot);
        }
    }

    /**
     * Public methods
     */

     /**
      * Save any changes to the battleplan for public viewing
      * Required ["name","notes","public"]
      */
    public function savePublicChanges($attributes = [])
    {
        $this->update($attributes);
        $this->saved = true;

        // Propagate battlefloor saving
        foreach ($this->battlefloors as $key => $battlefloor) {
            $battlefloor->savePublicChanges();
        }
    }

    public function deleteUnsavedChanges()
    {
        // Undo every battlefloor
        foreach ($this->battlefloors as $key => $battlefloor) {
            $battlefloor->deleteUnsavedChanges();
        }
    }

    /**
     * Model Overrides
     */

    /**
     * Create new plan
     * Required ["map_id","notes","public"]  
     */
    public static function create(array $attributes = [])
    {
        // Error check map exists
        // TODO should probable delegate this to the validator in the controller
        Map::findOrFail($attributes["map_id"]);

        // Defaults
        $attributes["name"] = isset($attributes["name"]) ? $attributes["name"] : self::DEFAULT_NAME;
        $attributes["description"] = isset($attributes["description"]) ? $attributes["description"] : self::DEFAULT_DESCRIPTION;
        $attributes["notes"] = isset($attributes["notes"]) ? $attributes["notes"] : self::DEFAULT_NOTES;

        // Parent Create method
        $battleplan = static::query()->create($attributes);

        $battleplan->init();

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

    // Initializes floors and slots
    // usefull for test cases
    public function init(){
        $this->createSlots(self::OPERATOR_SLOTS);
        $this->createFloors();
    }
}
