<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Battleplan;
use App\Models\Battlefloor;
use App\Models\Room;
use App\Models\Map;
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
        if(Auth::user() && Auth::user()->isAdmin()){
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

        // Return immediately if plan is public
        if ($battleplan->public) {
            return view("battleplan.show", compact("battleplan"));
        }

        // Owner of the private plan
        if (Auth::user() && Auth::user()->id == $battleplan->owner) {
            return view("battleplan.show", compact("battleplan"));
        }

        // Admin can always see the plan
        if(Auth::user() && Auth::user()->isAdmin()){
            return view("battleplan.show", compact("battleplan"));
        }

        abort(403);
    }

    /**
     * API's
     */

    /**
     * Create a battleplan
     */
    public function create(Request $request){

        $data = $request->validate([
            'map_id' => ['required'],
            'name' => [],
            'description' => [],
            'notes' => []
        ]);

        $bp = Battleplan::create([
            'map_id' => $data["map_id"],
            'name' => $data["name"],
            'owner_id' => Auth::User()->id
        ]);
        
        return response()->success(
            $bp
            ->slotData()
            ->mapData()
            ->BattlefloorData()
            ->first()
        );
    }

    /**
     * Retrieve a battleplan
     */
    public function read(Request $request, Battleplan $battleplan){

        // Return immediately if plan is public
        if ($battleplan->public) {
            return response()->success($this->fullPlanData($battleplan));
        }

        // Owner of the private plan
        if (Auth::user() && Auth::user()->id == $battleplan->owner) {
            return response()->success($this->fullPlanData($battleplan));
        }

        // Admin can always see the plan
        if(Auth::user() && Auth::user()->isAdmin()){
            return response()->success($this->fullPlanData($battleplan));
        }

        return response()->error("Plan is private");
    }

    /**
     * Mark the changes to the battleplan as being "saved"
     * and update the battle plans name, notes and public visibility
     */
    public function update(Request $request, Battleplan $battleplan){
  
        // validate request object contains all needed data
        $validatedData = $request->validate([
            'name' => 'required',
            'notes' => 'required',
            'public' => 'required',
        ]);
        
        // Is not owner
        if ($battleplan->Owner->id != Auth::User()->id) {
            return response()->error("Unauthorized", [], 403);
        }
        
        // propagate the save
        $battleplan->savePublicChanges([
            $validatedData["name"],
            $validatedData["notes"],
            $validatedData["public"]
        ]);

        // respond with update object
        return response()->success($this->fullPlanData($battleplan->fresh()));
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
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        // Create the copy and respond with the new instance
        return response()->success(
            Battleplan::copy($battleplan, Auth::user(), $validatedData["name"])
        );
    }
    
    /**
     * Vote for a battleplan
     */
    public function vote(Request $request, Battleplan $battleplan){
        
        // validate request object contains all needed data
        $validatedData = $request->validate([
            'value' => 'required',
        ]);

        // Cast the vote
        $vote = $battleplan->vote($value,Auth::user());
        
        // respond with the vote and the sum
        return response()->success([
            "vote" => $vote,
            "tally" => Battleplan::copy($battleplan, Auth::user(), $validatedData["name"])
        ]);
    }

    private function fullPlanData($battleplan){
        return $battleplan
            ->slotData()
            ->mapData()
            ->BattlefloorData()
            ->first();
    }
}
