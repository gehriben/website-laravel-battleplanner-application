<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Battleplan;
use App\Models\Battlefloor;
use App\Models\Room;
use App\Models\Map;
use App\Models\Draw;
use App\Models\Line;
use App\Models\Square;
use App\Models\Icon;
use App\Models\Coordinate;
use App\Models\Operator;

use Auth;
class BattleplanController extends Controller
{
    /**
     * Middleware checks
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ["copy", "vote", "delete", "update", "create"]]);
    }

    /**
     * Views
     */

    /**
     * List all plans
     */
    public function index(Request $request){
        $battleplans;

        // Admin see's all plans
        if(Auth::user() && Auth::user()->admin){
            $battleplans = Battleplan::all();
        } 
        
        // all other users only see the public plans
        else{
            $battleplans = Battleplan::public()->get();
        }

        return view("battleplan.index", compact("battleplans") );
    }

    /**
     * Show a battleplan
     */
    public function show(Request $request, Battleplan $battleplan){
        if (
            $battleplan->public ||                                  // Return immediately if plan is public
            Auth::user() && Auth::user() == $battleplan->owner ||   // Owner of the private plan
            Auth::user() && Auth::user()->admin                     // Admin can always see the plan
        ) {

            $battleplan = Battleplan::with(Battleplan::$printWith)->find($battleplan->id);

            if ($request->expectsJson()) {
                return $battleplan;
            }

            return view("battleplan.show", compact("battleplan"));
        }

        // Insufficient permissions
        abort(403);
    }

    /**
     * Show a battleplan
     */
    public function edit(Request $request, Battleplan $battleplan){

        if (
            Auth::user() && Auth::user() == $battleplan->owner ||   // Owner of the private plan
            Auth::user() && Auth::user()->admin                     // Admin can always see the plan
        ) {

            $battleplan = Battleplan::with(Battleplan::$printWith)->find($battleplan->id);
            $attackers = Operator::attackers()->get();
            $defenders = Operator::defenders()->get();
            if ($request->expectsJson()) {
                return $battleplan;
            }
            
            return view("battleplan.edit", compact("battleplan", "attackers", "defenders"));
        }

        // Insufficient permissions
        abort(403);
    }

    /**
     * New battleplan form
     */
    public function new(Request $request){
        $maps = Map::all();
        return view("battleplan.new",compact('maps'));
    }

    /**
     * API's
     */

    /**
     * Create a battleplan
     */
    public function create(Request $request){

        $data = $request->validate([
            'name' => ['required'],
            'map_id' => ['required', 'exists:maps,id'],
            'description' => [''],
            'notes' => [''],
            'public' => [''],
        ]);

        $data['owner_id'] = Auth::User()->id;
        $data['public'] = isset($data['public']);
        $data['description'] = isset($data['description']) && $data['description'] ? $data['description'] : "";
        $data['notes'] = isset($data['notes']) && $data['notes'] ? $data['notes'] : "";

        $battleplan = Battleplan::create($data);
        $battleplan = Battleplan::with(Battleplan::$printWith)->find($battleplan->id);

        if($request->wantsJson()){
            return response()->success($battleplan);
        }

        return redirect("battleplan/$battleplan->id/edit");
    }

    /**
     * Retrieve a battleplan
     */
    // public function read(Request $request, Battleplan $battleplan){

    //     // Return immediately if plan is public
    //     if ($battleplan->public) {
    //         return response()->success($this->fullPlanData($battleplan));
    //     }

    //     // Owner of the private plan
    //     if (Auth::user() && Auth::user()->id == $battleplan->owner) {
    //         return response()->success($this->fullPlanData($battleplan));
    //     }

    //     // Admin can always see the plan
    //     if(Auth::user() && Auth::user()->admin){
    //         return response()->success($this->fullPlanData($battleplan));
    //     }

    //     return response()->error("Unauthorized", [], 403);
    // }
    
    /**
     * Update a battleplan values
     */
    public function update(Request $request, Battleplan $battleplan){
        
        // Is not owner
        if ($battleplan->owner->id != Auth::User()->id) {
            return response()->error("Unauthorized", [], 403);
        }
        
        // validate request object contains all needed data
        $data = $request->validate([
            // Battleplan data
            'name' => ['required'],
            'description' => [''],
            'notes' => [''],
            'public' => [''],
            'battleplan' => ['required'],
            'operators' => ['required']
        ]);

        // dd($data);

        $data['public'] = isset($data['public']);
        $data['description'] = isset($data['description']) && $data['description'] ? $data['description'] : "";
        $data['notes'] = isset($data['notes']) && $data['notes'] ? $data['notes'] : "";

        $battleplan->update($data);
        $battleplan = Battleplan::with(Battleplan::$printWith)->find($battleplan->id);

        foreach ($data["battleplan"]["floors"] as $key => $floorData) {
            // Update BattleFloor
            $floorModel = Battlefloor::find($floorData["id"]);
            $floorModel->update($floorData);

            // default value
            $floorData["draws"] = isset($floorData["draws"]) ? $floorData["draws"] : [];

            // Delete draws that no longer exist
            $existingIds = array_column($floorModel->draws->toArray(), "id");
            $sentids = array_column($floorData["draws"], "id");
            $diffs = array_diff($existingIds, $sentids);
            foreach ($diffs as $key => $toDeleteId) {
                Draw::find($toDeleteId)->delete();
            }

            // Update draws / create new draws
            foreach ($floorData["draws"] as $key => $draw) {
                $draw['battlefloor_id'] = $floorModel->id;

                // Update existing
                if(isset($draw['id'])){
                    $drawModel = Draw::find($draw['id']);
                    $this->updateDraw($draw);
                }
                
                // No id, create new
                else{
                    $drawModel = Draw::create($draw);
                }
            }
        }

        $battleplan = Battleplan::with(Battleplan::$printWith)->find($battleplan->id);

        // respond with update object
        return response()->success($battleplan);
    }

    /**
     * Delete a battleplan
     */
    public function delete(Request $request, Battleplan $battleplan){

        // Is not owner
        if ($battleplan->owner->id != Auth::user()->id) {
            return response()->error("Unauthorized", [], 403);
        }

        // Do the delete
        $battleplan->delete();

        // Return successfull operation
        return response()->success();
    }

    /**
     * Make a copy of the battleplan
     */
    public function copy(Request $request, Battleplan $battleplan){
        
        // validate request object contains all needed data
        $data = $request->validate([
            'name' => 'required',
        ]);

        $data['user_id'] = Auth::user()->id;

        $copy = Battleplan::copy($battleplan,$data);
        
        // Create the copy and respond with the new instance
        return response()->success($copy);
    }
    
    /**
     * Helper function
     */

    // Account for all the possible draw types and how to update them
    private function updateDraw($data){
        // Note: There are no possible fiels to update in the draw, only the draw morph
        $draw = Draw::find($data['id']);
        
        switch (get_class($draw->drawable)) {
            case Square::class:
                $data['origin_id'] = Coordinate::create($data["origin"])->id;
                $data['destination_id'] = Coordinate::create($data["destination"])->id;

                $oldOrigin = $draw->drawable->origin;
                $oldDestination = $draw->drawable->destination;

                $draw->drawable->update($data);

                $oldOrigin->delete();
                $oldDestination->delete();

                break;
            
            case Line::class:
                // Generate new points
                $points = [];
                foreach ($data['points'] as $key => $point) {
                    $points[] = Coordinate::create($point);
                }

                // Delete existing
                foreach ($draw->drawable->coordinates as $key => $coordinate) {
                    $draw->drawable->coordinates()->detach($coordinate->id);
                    $coordinate->delete();
                }
                
                // Update call
                $draw->drawable->coordinates()->sync(array_column($points, 'id'));
                $draw->drawable->update($data);
                break;
                
            case Icon::class:
                
                $data['origin_id'] = Coordinate::create($data["origin"])->id;

                $oldOrigin = $draw->drawable->origin;
                $draw->drawable->update($data);
                $oldOrigin->delete();

                break;
            
        }
    }
}
