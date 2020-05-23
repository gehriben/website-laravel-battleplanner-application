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

        // Return immediately if plan is public
        if ($battleplan->public) {

            if ($request->expectsJson()) {
                return $this->fullPlanData($battleplan);
            }

            return view("battleplan.show", compact("battleplan"));
        }
        
        // Owner of the private plan
        if (Auth::user() && Auth::user() == $battleplan->owner) {
            
            if ($request->expectsJson()) {
                return $this->fullPlanData($battleplan);
            }

            return view("battleplan.show", compact("battleplan"));
        }

        // Admin can always see the plan
        if(Auth::user() && Auth::user()->admin){
            
            if ($request->expectsJson()) {
                return $this->fullPlanData($battleplan);
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

        // return $this->fullPlanData($battleplan);

        // Owner of the private plan
        if (Auth::user() && Auth::user() == $battleplan->owner) {
            
            if ($request->expectsJson()) {
                return $this->fullPlanData($battleplan);
            }

            return view("battleplan.edit", compact("battleplan"));
        }

        // Admin can always see the plan
        if(Auth::user() && Auth::user()->admin){
            
            if ($request->expectsJson()) {
                return $this->fullPlanData($battleplan);
            }

            return view("battleplan.show", compact("battleplan"));
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
            'description' => ['required'],
            'notes' => ['required'],
            'public' => ['required'],
            'map_id' => ['required', 'exist:maps,id'],
        ]);
        
        $data['owner_id'] = Auth::User()->id;

        $battleplan = Battleplan::create($data);
        
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
            'description' => ['required'],
            'notes' => ['required'],
            'public' => ['required'],
        ]);

        $battleplan->update($data);

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
    // private function fullPlanData($battleplan){
    //     return Battleplan::
    //         slotData()
    //         ->mapData()
    //         ->BattlefloorData()
    //         ->find($battleplan->id);
    // }
}
