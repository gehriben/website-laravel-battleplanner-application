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
        $maps = Map::all();
        return view("map.index", compact('maps'));
    }

    public function new(Request $request){
        return view("map.new", compact('map'));
    }

    public function edit(Request $request, Map $map){
        $map = $map
            ->with('floors')
            ->with('floors.media')
            ->with('thumbnail')
            ->find($map->id);
        // dd($map->toArray());
        return view("map.edit", compact('map'));
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
            'is_competitive' => [],
        ]);
        
        // Create map
        $data['is_competitive'] = isset($data['is_competitive']);
        $data['floor-files'] = isset($data['floor-files']) ? $data['floor-files'] : [];
        $data['floor-names'] = isset($data['floor-names']) ? $data['floor-names'] : [];
        $data['user_id'] = Auth::user()->id;
        $map = Map::create($data);
        
        // Create floors
        $floors = [];
        $order = 0;
        $map_id = $map->id;
        foreach ($data['floor-files'] as $key => $file) {
            $name = $data['floor-names'][$key];
            $floors[] = Floor::create(compact('name','file','order','map_id'));
            $order++;
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
            'is_competitive' => [],
        ]);
        
        // Update map
        $data['is_competitive'] = isset($data['is_competitive']);
        
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
        
        // // Create floors
        $data['floor-files'] = isset($data['floor-files']) ? $data['floor-files'] : [];
        $data['floor-names'] = isset($data['floor-names']) ? $data['floor-names'] : [];
        $data['floor-ids'] = isset($data['floor-ids']) ? $data['floor-ids'] : [];

        dd($data);

        $floors = [];
        $order = 0;
        $map_id = $map->id;
        foreach ($data['floor-files'] as $key => $file) {
            if(isset($data["floor-ids"][$order])){

            }
            $name = $data['floor-names'][$key];
            $floors[] = Floor::create(compact('name','file','order','map_id'));
            $order++;
        }

        if($request->wantsJson()){
            return response()->success($map);
        }
        return redirect("map/$map->id");
    }

}
