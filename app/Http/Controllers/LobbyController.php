<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Events
use App\Events\Lobby\RequestBattleplan;

// Models
use App\Models\Lobby;

class LobbyController extends Controller
{

    public function show(Request $request, $connection_string){
        $lobby = Lobby::byConnection($connection_string)->first();
        return view('lobby.show', compact('lobby'));
    }

   /**
   * APIs
   */
    public function requestBattleplan(Request $request, $connection_string){
        $lobby = Lobby::byConnection($connection_string)->first();

        // No lobby found
        if(!$lobby){
            abort(400);
        }

        event(new RequestBattleplan($lobby->connection_string));
        return response()->success();
    }

    public function responseBattleplan(Request $request, $connection_string){
        
        // validate request object contains all needed data
        $data = $request->validate([
            // Battleplan data
            'battleplanJson' => ['required'],
        ]);
        
        $lobby = Lobby::byConnection($connection_string)->first();
        $battleplan = Battleplan::findOrFail($data['battleplanJson']['id']);

        // user does not own the lobby or does not own the battleplan
        if(Auth::user()->id != $battleplan->owner->id || Auth::user()->id == $lobby->owner->id){
            abort(400);
        }

        // No lobby found
        if(!$lobby){
            abort(400);
        }

        event(new ResponseBattleplan($data['battleplanJson'],$lobby->connection_string));
        return response()->success();
    }
//    public function create(Request $request) {

//         $data['owner_id'] = Auth::user()->id;

//         $lobby = Lobby::create([]);

//         if($request->wantsJson()){
//             return response()->success($gadget);
//         }
//         return redirect("Loby/$gadget->id");
//     }

}
