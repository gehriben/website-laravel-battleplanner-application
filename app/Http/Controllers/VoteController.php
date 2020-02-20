<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

//  Models
use App\Models\Vote;

class VoteController extends Controller
{
    
    /**
     * Middleware checks
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'read', 'delete', 'update']]);
    }

    /**
     * API's
     */

    /**
     * Create a battleplan
     */
    public function create(Request $request){
        // validate request object contains all needed data
        $data = $request->validate([
            'value' => ['required'],
            'battleplan_id' => ['required','exists:battleplans,id'],
        ]);
        
        $data['user_id'] = Auth::user()->id;
        
        $vote = Vote::create($data);
        return response()->success($vote);
    }

    public function read(Request $request, Vote $vote){
        return response()->success($vote->fresh());
    }

    public function update(Request $request, Vote $vote){
        // User is not owner, error hadle
        if($vote->user->id != Auth::user()->id){
            return response()->error('Unauthorized', [], 403);
        }

        // validate request object contains all needed data
        $data = $request->validate([
            'value' => ['required']
        ]);
        
        $vote->update($data);

        return response()->success($vote->fresh());
    }
    
    public function delete(Request $request, Vote $vote){
        // User is not owner, error hadle
        if($vote->user->id != Auth::user()->id){
            return response()->error('Unauthorized', [], 403);
        }

        $vote->delete();

        return response()->success();
    }
}
