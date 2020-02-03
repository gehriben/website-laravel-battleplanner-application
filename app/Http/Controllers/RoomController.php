<?php

namespace App\Http\Controllers;
use App\Models\Room;
use App\Models\Map;
use App\Models\Battleplan;
use App\Models\Battlefloor;
use App\Models\Operator;
use App\Models\OperatorSlot;
use App\Models\Gadget;

use Illuminate\Http\Request;
use App\Events\Room\BattleplanChange;
use Auth;
class RoomController extends Controller
{
  
  /**
   * Middlewares
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

  /**
   * Views
   */
  public function index(){
    return view("room.index");
  }

  
  public function show(Request $request, $conn_string){
    // settings
    $listenSocket = env("LISTEN_SOCKET");

    // Find correct room
    $room = Room::Connection($conn_string);

    // Error handle room DNE
    if(!$room){
      return redirect()->route('Room.index')->with("error", ["error" => "Room not found!"]);
    } 

    // Gather relevant data
    $maps = Map::orderBy('name', 'asc')->get();
    $atk_operators = Operator::attackers();
    $def_operators = Operator::defenders();
    $all_operators = Operator::all()
        ->sortBy(function($op) {
            return $op->name;
        });
    $gadgets = Gadget::all()
        ->sortBy(function($gadget) {
            return $gadget->name;
        });
    $battleplans = Battleplan::where('owner', Auth::User()->id)
        ->where('saved', true)
        ->get();

      // Respond
    return view("room.show", compact("maps", "room", 'battleplans', 'atk_operators', 'def_operators', 'all_operators', 'listenSocket','gadgets'));
  }

  /**
   * Api's
   */

   /**
    * Create a room
    */
  public function create(Request $request){

    // Create the room
    $room = Room::create([
        'owner' => Auth::User()->id,
        'connection_string' => uniqid()
    ]);

    // Respond with redirect
    return response()->success($room);
  }

  public function setBattleplan(Request $request){
    // define variables
    $room = Room::Connection($request->conn_string);
    $battleplan = Battleplan::findOrFail($request->battleplanId);

    // make sure the deleter is also the owner of the map
    if (!$room->Owner == Auth::User()) {
        return response()->error("You do not own the room.");
    }

    // Undo any unsaved work
    $battleplan->deleteUnsavedChanges();

    // set the battleplan
    $room->battleplan_id = $battleplan->id;
    $room->save();

    // Fire event to listeners
    event(new BattleplanChange($room->connection_string));

    // Respond
    return response()->json($room);
  }

  public function getBattleplan($conn_string){
    // variable declaration
    $battleplan = Room::Connection($conn_string)->Battleplan;
    if($battleplan == null){
        return null;
    }
    return response()->json(Battleplan::json($battleplan->id));
  }

}
