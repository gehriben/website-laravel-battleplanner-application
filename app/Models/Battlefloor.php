<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Line;

class Battlefloor extends Model
{
    public $timestamps = true;
    
    protected $fillable = [
        'battleplan_id', 'floor_id'
    ];

    /**
     * Relationships
     */
    public function floor()
    {
        return $this->belongsTo('App\Models\Floor');
    }

    public function battleplan()
    {
        return $this->belongsTo('App\Models\Battleplan', 'battleplan_id', 'id');
    }

    public function draws()
    {
        return $this->hasMany('App\Models\Draw', 'battlefloor_id');
    }

    public function drawsCopiable()
    {
        return $this->hasMany('App\Models\Draw', 'battlefloor_id')
            ->where('deleted', '=', false)
            ->where('saved', '=', true);
    }

    /**
     * Copy Constructor
     * TODO: Refactor
     */
    public function copy($battlefloor){
        // replicate draws
        foreach ($battlefloor->drawsCopiable as $key => $draw) {
            // dd($this->id);
            $newDraw = Draw::create([
                "battlefloor_id" => $this->id,
                "originX" => $draw->originX,
                "originY" => $draw->originY,
                "destinationX" => $draw->destinationX,
                "destinationY" => $draw->destinationY,
                "user_id" => $draw->user_id,
                "drawable_type" => $draw->drawable_type,
                "drawable_id" => $draw->id,
                "saved" => true
            ]);

            $subDraw = $draw->drawable;
            $type = $draw->drawable_type;

            $fields = $subDraw->toArray();

            unset($fields["id"]);

            $newSubType = $type::create($fields);

            $newDraw->drawable_id = $newSubType->id;
            $newDraw->save();
        }
    }

    /**
     * Save any changes to the floors for public viewing
     */
    public function savePublicChanges()
    {
        // Propagate changes for draws
        foreach ($this->draws as $key => $draw) {

            // Deleted draw
            // TODO enforce drawable as part of migration cascading effect
            if($draw->deleted){
                $draw->drawable()->delete();
                $draw->delete();
                continue;
            } 

            // Update to saved status
            $draw->saved = true;
            $draw->save();
            continue;
        }
    }

    public function deleteUnsavedChanges()
    {
        // Undo unsaved lines
        foreach ($this->draws as $this->draws => $draw) {
            if (!$draw->saved) {
                $draw->delete();
            }

            if ($draw->deleted) {
                $draw->restore();
            }
        }
    }
}
