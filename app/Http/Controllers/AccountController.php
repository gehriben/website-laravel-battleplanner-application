<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AccountController extends Controller
{
  public function index(Request $request){
    $user = Auth::user();
    $battleplans = $user->battleplans;
    return view("account.index", compact('user','battleplans'));
  }
}
