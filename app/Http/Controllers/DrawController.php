<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Draw;
use App\Models\Line;
use App\Models\Square;
use App\Models\Icon;
use Auth;

// events
use App\Events\Draw\CreateDraws;

class DrawController extends Controller
{

    /**
     * API's
     */

     /**
      * Create a single draw
      */
    public function create(Request $request){
        $draws;

        // Batch upload
        if(isset($request->all()[0]) && is_array($request->all()[0])){
            $draws = $this->batchCreate($request);
        }

        // single create
        else{
            $draws = $this->singleCreate($request);
        }
        
        // Fire event on listeners for socket.io
        //event(new CreateDraws($draws, $request->conn_string, $request->userId));
        
        // Create the draw and return it with the response
        return response()->success($draws);

    }

    /**
     * Delete a single group
     */
    public function delete(Request $request, Draw $draw){

        // set thhe deleted flag
        $draw = $this->deleteDraw($draw->id);

        // Fire event on listeners for socket.io
        //event(new CreateDraws([$draw], $request->conn_string, $request->userId));

        // Create the draw and return it with the response
        return response()->success($draw);
    }
     
    /**
     * Delete numerous draws from a single request
     * (This is optimized for async functions to minimize the number of requests made to the backend)
     */
    public function batchDelete(Request $request){
        $data = $request->validate([
            'ids.*' =>[ "required", "exists:draws,id"]
        ]);

        // Declarations
        $deletedDraws = []; // used for event notification

        // delete the list
        foreach ($data["ids"] as $key => $id) {
        
            $deleted = $this->deleteDraw($id);
            if($deleted){
                $deletedDraws[] = $deleted;
            }
        }

        // Fire event on listeners for socket.io
        //event(new DeleteDraws($deletedDraws, $request->conn_string, $request->userId));

        // Respond
        return response()->json($deletedDraws);
    }

    

    /**
     * Helper functions
     */

     /**
     * Single creation of a draw object
     */
    private function singleCreate(Request $request){
        // validate request object contains all needed data
        $data = $request->validate([
            "battlefloor_id" => 'required',
            "originX" => 'required',
            "originY" => 'required',
            "destinationX" => 'required',
            "destinationY" => 'required',
            'drawable_type' => 'required',
            "color" => 'required',
            "lineSize" => 'required',
        ]);

        // create model instance
        return  [$this->createDraw($data)];
    }
   

    /**
     * Create numerous draws from a single request
     * (This is optimized for async functions to minimize the number of requests made to the backend)
     */
    private function batchCreate(Request $request)
    {
        $draws = [];

        // validate request object contains all needed data
        $data = $request->validate([
            "*" => ["battlefloor_id" => 'required',
            "originX" => 'required',
            "originY" => 'required',
            "destinationX" => 'required',
            "destinationY" => 'required',
            'drawable_type' => 'required',
            "color" => 'required',
            "lineSize" => 'required',]
        ]);
        
        // Create each new draw
        foreach ($request->all() as $key => $attributes) {
            $draws[] =  $this->createDraw($attributes);
        }
        
        return $draws;
    }

    /**
     * Creates a draw and it's morph
     */
    private function createDraw($attributes = []){
        
        // Declarations
        $allowedTypes = ['Line', 'Square', 'Icon'];

        // not an allowed type
        if(!in_array($attributes["drawable_type"], $allowedTypes)){
            throw new \Exception("Illegal draw type: {$attributes['drawable_type']}");
        }
        
        $modelPath = "App\Models\\{$attributes['drawable_type']}";
        $drawable = $modelPath::create($attributes);

        // Make draw morph relationship
        return Draw::create(
            array_merge(
                $attributes,
                [
                    "user_id" => Auth::User()->id,
                    "drawable_type" => $modelPath,
                    "drawable_id" => $drawable->id
                ]
            )
        );
    }

    /**
     * Delete a draw (Soft deletes)
     */
    private function deleteDraw($id){

        // Make draw morph relationship
        $draw = Draw::find($id);

        if ($draw) {

            // Delete object
            $draw->setDeleted();

            // Add to list
            $deletedDraws[] = $draw;
        }
        return $draw;
    }
}
