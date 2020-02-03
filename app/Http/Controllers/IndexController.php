<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
  /**
   * Views
   */

  /**
   * Landing page
   */
  public function index(){
    return View("index.index");
  }
}
