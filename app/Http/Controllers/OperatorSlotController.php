<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OperatorSlot;
use App\Models\Operator;
use App\Events\Battleplan\ChangeOperatorSlot;

class OperatorSlotController extends Controller
{
    /**
     * API's
     */
    public function update(Request $request, OperatorSlot $operatorSlot){
         // validate request object contains all needed data
         $validatedData = $request->validate([
            'operatorId' => 'required'
        ]);
        
        // Update the operator
        $operatorSlot->setOperator($validatedData['operatorId']);

        // Fire event on listeners for socket.io
        event(new ChangeOperatorSlot($request->conn_string, $operatorSlot->id));

        return response()->success($operatorSlot);
    }
}
