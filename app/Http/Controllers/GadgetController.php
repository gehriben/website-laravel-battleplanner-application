<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gadget;
use App\Models\Media;
use App\Models\Operator;
use Auth;

class GadgetController extends Controller {

  /**
   * Middleware checks
   */
  public function __construct()
  {
      $this->middleware('isAdmin');
  }

  /**
   * Views
   */

  public function index(Request $request) {
    $gadgets = Gadget::all();
    return view("gadgets.index", compact('gadgets'));
  }

  public function new(Request $request) {
    $ops = Operator::all();
    return view("gadgets.new", compact ('ops'));
  }

  public function show(Request $request, Gadget $gadget) {
    $gadget = $gadget
        ->with('icon')
        ->find($gadget->id);
    $operators = $gadget->operators;
    return view("gadgets.show", compact('gadget', 'operators'));
  }

  public function edit(Request $request, Gadget $gadget) {
    $gadget = $gadget
        ->with('icon')
        ->find($gadget->id);
    $ops = Operator::all();
    return view("gadgets.edit", compact ('gadget', 'ops'));
  }

  /**
   * APIs
   */

   public function create(Request $request) {
     $data = $request->validate([
         'name' => ['required'],
         'icon' => ['required','file'],
         'operators' => []
     ]);

     $data['user_id'] = Auth::user()->id;
     $data['icon_id'] = Media::fromFile($data['icon'], "gadgets/{$data['name']}", "public")->id;
     
     $gadget = Gadget::create($data);

     if(isset($data['operators'])) {
         $data['operators'] = !in_array("", $data['operators']) ? $data['operators'] : [];
         $gadget->operators()->sync($data['operators']);
     }

     if($request->wantsJson()){
         return response()->success($gadget);
     }
     return redirect("gadgets/$gadget->id");
   }

   public function update(Request $request, Gadget $gadget) {
     $data = $request->validate([
         'name' => ['required'],
         'icon' => ['file'],
         'operators' => []
     ]);

     if(isset($data["icon"])){
         if($gadget->media){
             $gadget->media->delete(); // delete old one
         }
         $media = Media::fromFile($data['icon'], "gadgets/{$gadget->name}", "public"); // create new one
         $data['icon_id'] = $media->id; // associate
     }

     $gadget->update($data);
     $gadget = $gadget->fresh();

     if(isset($data['operators'])) {
         $data['operators'] = !in_array("", $data['operators']) ? $data['operators'] : [];
         $gadget->operators()->sync($data['operators']);
     }

     if($request->wantsJson()){
         return response()->success($gadget);
     }
     return redirect("gadgets/$gadget->id");
   }

   public function delete(Request $request, Gadget $gadget) {
     $gadget->delete();

     if($request->wantsJson()){
         return response()->success();
     }

     return redirect("/gadgets");
   }
}
