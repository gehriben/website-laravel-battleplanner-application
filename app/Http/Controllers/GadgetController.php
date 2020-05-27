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

     // TODO: link gadget to its ops

     $gadget = Gadget::create($data);

     if($request->wantsJson()){
         return response()->success($gadget);
     }
     return redirect("gadgets/$gadget->id");
   }
}
