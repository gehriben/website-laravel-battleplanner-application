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
use App\Models\OperatorSlot;
use App\Models\Gadget;
use App\Models\Lobby;

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
        $pageNum = $request->input('page') ? $request->input('page') : 1;
        $itemsPerPage = $request->input('items') ? $request->input('items') : 10;

        $totalPages = Battleplan::public()->count() / $itemsPerPage;
        $battleplans = Battleplan::public()->orderBy('created_at','DESC')->paginate($itemsPerPage);

        return view("battleplan.index", compact("battleplans",'pageNum','totalPages','itemsPerPage') );

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

            return view("battleplan.show", compact("battleplan"));
        }

        // Insufficient permissions
        abort(403);
    }

    /**
     * Show a battleplan
     */
    public function editGenerateRoom(Request $request, Battleplan $battleplan){

        if (
            Auth::user() && Auth::user() == $battleplan->owner ||   // Owner of the private plan
            Auth::user() && Auth::user()->admin                     // Admin can always see the plan
        ) {
            $lobby = Lobby::create([
                'owner_id' => Auth::user()->id
            ]);

            return redirect("battleplan/{$battleplan->id}/edit/{$lobby->connection_string}");
        }

        // Insufficient permissions
        abort(403);
    }

    public function edit(Request $request, Battleplan $battleplan, $connection_string){
        if (
            Auth::user() && Auth::user() == $battleplan->owner ||   // Owner of the private plan
            Auth::user() && Auth::user()->admin                     // Admin can always see the plan
        ) {

            $lobby = Lobby::ByConnection($connection_string)->first();

            // no lobby or not the owner of said lobby, generate new lobby
            if(!$lobby || $lobby->owner->id != Auth::user()->id){
                return redirect("battleplan/{$battleplan->id}/edit");
            }

            $battleplan = Battleplan::with(Battleplan::$printWith)->find($battleplan->id);
            $myBattleplans = Auth::user()->battleplans;
            $attackers = Operator::attackers()->get();
            $defenders = Operator::defenders()->get();
            $gadgets = Gadget::all();
            $operators = Operator::all();

            $listenSocket = env("LISTEN_SOCKET");

            return view("battleplan.edit", compact("battleplan", "attackers", "defenders",'gadgets','lobby','listenSocket','operators','myBattleplans'));
        }

        // Insufficient permissions
        abort(403);
    }

    /**
     * New battleplan form
     */
    public function new(Request $request, $connection_string = null){
        $maps = Map::available()->get();
        return view("battleplan.new",compact('maps','connection_string'));
    }

    /**
     * API's
     */

    public function get(Request $request, Battleplan $battleplan){
        if (
            $battleplan->public ||                                  // Return immediately if plan is public
            Auth::user() && Auth::user() == $battleplan->owner ||   // Owner of the private plan
            Auth::user() && Auth::user()->admin                     // Admin can always see the plan
        ) {
            $battleplan = Battleplan::with(Battleplan::$printWith)->find($battleplan->id);
            return $battleplan;
        }

        // Insufficient permissions
        abort(403);
    }

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
            'connection_string' => [''],
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

        $lobby;
        if(isset($data['connection_string'])){
            $lobby = Lobby::ByConnection($data['connection_string'])->first();

            // lobby exists and owner of said lobby
            if($lobby && $lobby->owner->id == Auth::user()->id){
                return redirect("battleplan/{$battleplan->id}/edit/" . $data['connection_string']);
            }
        }

        return redirect("battleplan/$battleplan->id/edit/");
    }

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
        ]);

        // dd($data);

        $data['public'] = (isset($data['public'])) ? $data['public'] == "true" : false;
        $data['description'] = isset($data['description']) && $data['description'] ? $data['description'] : "";
        $data['notes'] = isset($data['notes']) && $data['notes'] ? $data['notes'] : "";

        $battleplan->update($data);
        $battleplan = Battleplan::with(Battleplan::$printWith)->find($battleplan->id);

        // Update operators on the battleplan
        foreach ($data['battleplan']["operators"] as $key => $operatorSlotData) {
            $operatorSlotModel = OperatorSlot::find($operatorSlotData['id']);
            $operatorSlotModel->update($operatorSlotData);
        }

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
                    if($draw['updated'] === 'true'){
                        // dd($draw['updated']);
                        $drawModel = Draw::find($draw['id']);
                        $this->updateDraw($draw);
                    }
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

        return redirect()->route('Account.index');
        // Return successfull operation
        // return response()->success();
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

                // we need to optimize the compressions of objects or else we go over the alloted php POST size limit.
                // Serialization is a 2n array where all 1n are x and 2n are y coordinates
                $explodedPoints = explode(',', $data['points']);

                $points = [];
                for ($i=0; $i < count($explodedPoints); $i++) {
                    $points[] = Coordinate::create(['x' => $explodedPoints[$i], 'y' => $explodedPoints[++$i]]);
                }

                // Delete existing
                $toDeleteIds = array_column($draw->drawable->coordinates->toArray(), 'id');
                $draw->drawable->coordinates()->detach($toDeleteIds);
                Coordinate::whereIn('id', $toDeleteIds)->delete();

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
