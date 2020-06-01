<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operator;
use App\Models\Media;
use App\Models\Gadget;
use Auth;

class OperatorController extends Controller {

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
    $ops = Operator::all();
    return view("operators.index", compact('ops'));
  }

  public function new(Request $request) {
    $gadgets = Gadget::all();
    return view("operators.new", compact('gadgets'));
  }

  public function show(Request $request, Operator $operator) {
    $op = $operator
        ->with('icon')
        ->find($operator->id);
    $gadgets = $op->gadgets;
    return view("operators.show", compact('op', 'gadgets'));
  }

  public function edit(Request $request, Operator $operator){
    $op = $operator
        ->with('icon')
        ->find($operator->id);
    $gadgets = Gadget::all();
    return view("operators.edit", compact('op', 'gadgets'));
  }

  /**
   * APIs
   */

  public function create(Request $request) {

    $data = $request->validate([
        'name' => ['required'],
        'icon' => ['required','file'],
        'attacker' => [],
        'colour' => ['required'],
        'gadgets' => []
    ]);

    // Checkbox is set to 'on' if true, null if false. Convert to bool value
    $data['attacker'] = isset($data['attacker']);
    $data['user_id'] = Auth::user()->id;
    $data['icon_id'] = Media::fromFile($data['icon'], "operators/{$data['name']}", "public")->id;

    $operator = Operator::create($data);

    if(isset($data['gadgets'])) {
        $data['gadgets'] = !in_array("", $data['gadgets']) ? $data['gadgets'] : [];
        $operator->gadgets()->sync($data['gadgets']);
    }

    if($request->wantsJson()){
        return response()->success($operator);
    }
    return redirect("operators/$operator->id");
  }

  public function update(Request $request, Operator $operator){

    $data = $request->validate([
        'name' => ['required'],
        'icon' => ['file'],
        'attacker' => [],
        'colour' => ['required'],
        'gadgets' => []
    ]);

    $data['attacker'] = isset($data['attacker']);

    if(isset($data["icon"])){
        if($operator->media){
            $operator->media->delete(); // delete old one
        }
        $media = Media::fromFile($data['icon'], "operators/{$operator->name}", "public"); // create new one
        $data['icon_id'] = $media->id; // associate
    }

    $operator->update($data);
    $operator = $operator->fresh();

    if(isset($data['gadgets'])) {
        $data['gadgets'] = !in_array("", $data['gadgets']) ? $data['gadgets'] : [];
        $operator->gadgets()->sync($data['gadgets']);
    }

    if($request->wantsJson()){
        return response()->success($operator);
    }
    return redirect("operators/$operator->id");
  }

  public function delete(Request $request, Operator $operator) {
    $operator->delete();

    if($request->wantsJson()){
        return response()->success();
    }

    return redirect("/operators");
  }
}
