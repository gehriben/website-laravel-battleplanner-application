<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operator;
use App\Models\Media;
use Auth;

class OperatorController extends Controller {

  /**
   * Views
   */

  public function index(Request $request) {
    $ops = Operator::all();
    return view("operators.index", compact('ops'));
  }

  public function new(Request $request) {
    return view("operators.new");
  }

  public function show(Request $request, Operator $operator) {
    $op = $operator
        ->with('icon')
        ->find($operator->id);
    return view("operators.show", compact('op'));
  }

  public function edit(Request $request, Operator $operator){
    $op = $operator
        ->with('icon')
        ->find($operator->id);
    return view("operators.edit", compact('op'));
  }

  /**
   * Views
   */
  public function create(Request $request) {

    $data = $request->validate([
        'name' => ['required'],
        'icon' => ['required','file'],
        'attacker' => [],
        'colour' => ['required']
    ]);

    // Checkbox is set to 'on' if true, null if false. Convert to bool value
    $data['attacker'] = isset($data['attacker']);
    $data['user_id'] = Auth::user()->id;

    $operator = Operator::create($data);

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
        'colour' => ['required']
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

    if($request->wantsJson()){
        return response()->success($operator);
    }
    return redirect("operators/$operator->id");
  }
}
