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
        ->with('media')
        ->find($operator->id);
    return view("operators.show", compact('op'));
  }

  public function create(Request $request) {

    $data = $request->validate([
        'name' => ['required'],
        'icon' => ['required','file'],
        'is_attacker' => [],
        'colour' => ['required']
    ]);

    $data['is_attacker'] = isset($data['is_attacker']);
    $data['user_id'] = Auth::user()->id;

    $operator = Operator::create($data);

    if($request->wantsJson()){
        return response()->success($operator);
    }
    return redirect("operators/$operator->id");
  }
}
