<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Middleware checks
     */
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function index(Request $request){
        return view("admin.index");
    }
}
