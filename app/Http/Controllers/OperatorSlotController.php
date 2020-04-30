<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

// Models
use App\Models\OperatorSlot;
use App\Models\Operator;
use App\Events\Battleplan\ChangeOperatorSlot;

class OperatorSlotController extends Controller
{
    /**
     * Middleware checks
     */
    // public function __construct()
    // {
    //     $this->middleware('auth', ['only' => ["update"]]);
    // }

    /**
     * API's
     */
    // public function update(Request $request, OperatorSlot $operatorSlot){
    //     // validate request object contains all needed data
    //     $data = $request->validate([
    //         'operator_id' => ['required', 'exists:Operators,id']
    //     ]);
        
    //     // // Is not owner
    //     // if ($operatorSlot->battleplan->owner->id != Auth::User()->id) {
    //     //     return response()->error("Unauthorized", [], 403);
    //     // }
        
    //     // // Update the operator
    //     // $operatorSlot->update($data);

    //     // Fire event on listeners for socket.io
    //     //event(new ChangeOperatorSlot($data['conn_string'], $data['operator_id']));

    //     return response()->success($operatorSlot);
    // }
}
