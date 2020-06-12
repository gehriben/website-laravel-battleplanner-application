<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

// Events
use App\Events\Lobby\RequestBattleplan;
use App\Events\Lobby\ResponseBattleplan;
use App\Events\Lobby\ReceiveDrawDelete;
use App\Events\Lobby\ReceiveDrawCreate;
use App\Events\Lobby\ReceiveOperatorSlotChange;
use App\Events\Lobby\ReceiveDrawUpdate;
use App\Events\Lobby\ReceiveConnected;
use App\Events\Lobby\ReceiveReload;

// Models
use App\Models\Lobby;
use App\Models\Battleplan;
use App\Models\Operator;
use App\Models\Gadget;

class LobbyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request, $connection_string){
        $lobby = Lobby::byConnection($connection_string)->with('owner')->first();
        
        $attackers = Operator::attackers()->get();
        $defenders = Operator::defenders()->get();
        $gadgets = Gadget::all();
        $operators = Operator::all();
        $listenSocket = env("LISTEN_SOCKET");

        return view('lobby.show', compact("attackers", "defenders",'gadgets','lobby','listenSocket', 'operators'));
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
            'appJson' => ['required'],
        ]);
        
        $lobby = Lobby::byConnection($connection_string)->first();
        // dd($data['battleplanJson']['battleplan']);
        $battleplan = Battleplan::findOrFail($data['appJson']['battleplan']['id']);

        // user does not own the lobby or does not own the battleplan
        if(Auth::user()->id != $battleplan->owner->id || Auth::user()->id != $lobby->owner->id){
            abort(400);
        }

        // No lobby found
        if(!$lobby){
            abort(400);
        }

        event(new ResponseBattleplan($lobby->connection_string,$data['appJson']));
        return response()->success();
    }

    public function requestDrawDelete(Request $request, $connection_string){
        
        // validate request object contains all needed data
        $data = $request->validate([
            // Battleplan data
            'localId' => ['required'],
        ]);
        
        $lobby = Lobby::byConnection($connection_string)->first();
        
        // No lobby found
        if(!$lobby){
            abort(400);
        }

        event(new ReceiveDrawDelete($lobby->connection_string,$data['localId'],Auth::user()));
        return response()->success();
    }

    public function requestDrawCreate(Request $request, $connection_string){
        
        // validate request object contains all needed data
        $data = $request->validate([
            // Battleplan data
            'drawData' => ['required'],
            'floorData' => ['required'],
        ]);
        
        $lobby = Lobby::byConnection($connection_string)->first();
        
        // No lobby found
        if(!$lobby){
            abort(400);
        }

        event(new ReceiveDrawCreate($lobby->connection_string,$data['drawData'],$data['floorData'],Auth::user()));
        return response()->success();
    }

    public function requestOperatorSlotChange(Request $request, $connection_string){
        
        // validate request object contains all needed data
        $data = $request->validate([
            // Battleplan data
            'operatorSlotData' => ['required']
        ]);
        
        $lobby = Lobby::byConnection($connection_string)->first();
        
        // No lobby found
        if(!$lobby){
            abort(400);
        }

        event(new ReceiveOperatorSlotChange($lobby->connection_string,$data['operatorSlotData'],Auth::user()));
        return response()->success();
    }

    public function requestDrawUpdate(Request $request, $connection_string){
        
        // validate request object contains all needed data
        $data = $request->validate([
            // Battleplan data
            'drawData' => ['required']
        ]);
        
        $lobby = Lobby::byConnection($connection_string)->first();
        
        // No lobby found
        if(!$lobby){
            abort(400);
        }

        event(new ReceiveDrawUpdate($lobby->connection_string,$data['drawData'],Auth::user()));
        return response()->success();
    }

    public function connected(Request $request, $connection_string){
        // validate request object contains all needed data
        $data = $request->validate([
            'socketId' => ['required','string']
        ]);
        
        $lobby = Lobby::byConnection($connection_string)->first();
        
        // No lobby found
        if(!$lobby){
            abort(400);
        }

        event(new ReceiveConnected($lobby->connection_string, Auth::user(), $data['socketId']));

        return response()->success();
    }

    public function requestReload(Request $request, $connection_string){
        // validate request object contains all needed data
        $data = $request->validate([
            
        ]);
        
        $lobby = Lobby::byConnection($connection_string)->first();
        
        // No lobby found
        if(!$lobby){
            abort(400);
        }

        event(new ReceiveReload($lobby->connection_string, Auth::user()));

        return response()->success();
    }
}
