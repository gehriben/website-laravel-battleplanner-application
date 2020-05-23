<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Map;
use App\Models\Media;
use App\Models\Floor;
use Auth;

class MapController extends Controller
{

    /**
     * Views
     */

    public function index(Request $request){
        return view("map.index", ['maps' => Map::all()]);
    }

    public function new(Request $request){
        return view("map.new");
    }

    public function edit(Request $request, Map $map){
        $map = Map::with(Map::$printWith)
            ->with(array('floors' => function($query) {
                $query->orderBy('order', 'ASC');
            }))
            ->find($map->id);
            
        return view("map.edit", compact('map'));
    }

    public function show(Request $request, Map $map){
        $map = Map::with(Map::$printWith)
          ->with(array('floors' => function($query) {
              $query->orderBy('order', 'ASC');
          }))
          ->find($map->id);
        return view("map.show", compact('map'));
    }

    /**
     * API's
     */

    /**
     * Create a Map
     */
    public function create(Request $request){
        // validate request object contains all needed data
        $data = $request->validate([
            'name' => ['required'],
            'thumbnail' => ['required','file'],
            'floor-files.*' => ['file'],
            'floor-names' => [],
            'floor-ids' => [],
            'floor-orders' => [],
            'competitive' => [],
        ]);

        // Checkbox is set to 'on' if true, null if false. Convert to bool value
        $data['competitive'] = isset($data['competitive']);

        $data['floor-files'] = isset($data['floor-files']) ? $data['floor-files'] : [];
        $data['floor-names'] = isset($data['floor-names']) ? $data['floor-names'] : [];
        $data['user_id'] = Auth::user()->id;
        $map = Map::create($data);

        // Create floors
        $floors = [];
        $map_id = $map->id;
        foreach ($data['floor-names'] as $key => $name) {
            $order = $data['floor-orders'][$key];
            $source = $data['floor-files'][$key];
            $floors[] = Floor::create(compact('name','source','order','map_id'));
        }

        if($request->wantsJson()){
            return response()->success($map);
        }
        return redirect("map/$map->id");
    }

    public function update(Request $request, Map $map){
        // validate request object contains all needed data
        $data = $request->validate([
            'name' => ['required'],
            'thumbnail' => ['file'],
            'floor-files.*' => ['file'],
            'floor-names' => [],
            'floor-orders' => ['required'],
            'floor-ids' => [],
            'competitive' => [],
        ]);
        
        // Update map
        $data['competitive'] = isset($data['competitive']);

        // Update the thumbnail
        if(isset($data["thumbnail"])){
            if($map->thumbnail){
                $map->thumbnail->delete(); // delete old one
            }
            $media = Media::fromFile($data['thumbnail'], "maps/{$map->name}", "public"); // create new one
            $data['media_id'] = $media->id; // associate
        }

        $map->update($data);
        $map = $map->fresh();

        $floorids = array_column($map->floors->toArray(), "id");
        $sentids = $data["floor-ids"];
        $diffs = array_diff($floorids, $sentids);

        foreach($diffs as $diff) {
          Floor::find($diff)->delete();
        }

        // // Create floors
        $data['floor-files'] = isset($data['floor-files']) ? $data['floor-files'] : null;
        $data['floor-names'] = isset($data['floor-names']) ? $data['floor-names'] : [];
        $data['floor-orders'] = isset($data['floor-orders']) ? $data['floor-orders'] : [];

        $floors = [];
        $map_id = $map->id;

        foreach ($data['floor-names'] as $key => $name) {
            $order = $data['floor-orders'][$key];
            $file = isset($data['floor-files'][$key]) ? $data['floor-files'][$key] : null;
            if(!$data['floor-ids'][$key]){
              $floors[] = Floor::create(compact('name','file','order','map_id'));
            }
            else {
              $floors[] = $this->updateFloor(Floor::find($data["floor-ids"][$key]), compact('name','order','map_id'), $file, $data["name"]);
            }
        }

        if($request->wantsJson()){
            return response()->success($map);
        }
        return redirect("map/$map->id");
    }

    public function delete(Map $map) {
      $map = Map::find($map->id)->delete();

      if($request->wantsJson()){
          return response()->success($map);
      }

      return redirect("map/");
    }

    private function updateFloor(Floor $floor, $data, $file, $mapName) {
      if($file) {
        if($floor->media) {
          $floor->media->delete();
        }
        $newFile = Media::fromFile($file, "maps/" . $mapName, "public");
        $data["media_id"] = $newFile->id;
      }
      $floor->update($data);
    }

}
