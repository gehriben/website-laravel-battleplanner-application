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
        // @here seperate into methods 

        // Batch upload
        if(is_array($request->all()[0])){
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
            foreach ($request->draws as $key => $attributes) {
                $draw =  $this->createDraw($attributes);
                if($draw){
                    $draws[] = $draw;
                }
            }
            
            // Fire event on listeners for socket.io
            event(new CreateDraws($draws, $request->conn_string, $request->userId));

            // Create the draw and return it with the response
            return response()->success($draw);
        }

        // single create
        else{
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
            $draw = $this->createDraw($data);
            
            // Fire event on listeners for socket.io
            event(new CreateDraws([$draw], $request->conn_string, $request->userId));

            // Create the draw and return it with the response
            return response()->success($draw);
        }

    }

    /**
     * Delete a single group
     */
    public function delete(Request $request, Draw $draw){

        // set thhe deleted flag
        $draw = $this->deleteDraw($draw->id);

        // Fire event on listeners for socket.io
        event(new CreateDraws([$draw], $request->conn_string, $request->userId));

        // Create the draw and return it with the response
        return response()->success($draw);
    }
     
    /**
     * Group functions
     * (Optimized)
     */

    /**
     * Delete numerous draws from a single request
     * (This is optimized for async functions to minimize the number of requests made to the backend)
     */
    private function batchDelete(Request $request){
        // Declarations
        $deletedDraws = []; // used for event notification

        // delete the list
        foreach ($request->draws as $key => $attributes) {
            $deleted = $this->deleteDraw($attributes["id"]);
            if($deleted){
                $deletedDraws[] = $deleted;
            }
        }
        
        // Fire event on listeners for socket.io
        event(new DeleteDraws($deletedDraws, $request->conn_string, $request->userId));

        // Respond
        return response()->json($deletedDraws);
    }

    /**
     * Create numerous draws from a single request
     * (This is optimized for async functions to minimize the number of requests made to the backend)
     */
    private function batchCreate(Request $request)
    {
        $draws = [];

        // Create each new draw
        foreach ($request->draws as $key => $attributes) {
            $draw =  $this->createDraw($attributes);
            if($draw){
                $draws[] = $draw;
            }
        }
        
        // Fire event on listeners for socket.io
        event(new CreateDraws($draws, $request->conn_string, $request->userId));

        // Respond
        return response()->success($draws);
    }

    /**
     * Helper functions
     */

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
    private function deleteDraw($id = null){
        // Draw was never saved, it was deleted before being created in the DB
        if(!$id){
            return false;
        }

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
