<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Middleware checks
     */
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    /**
     * Display Routes
     */
    public function index(Request $request){
        $pageNum = $request->input('page') ? $request->input('page') : 1;
        $itemsPerPage = $request->input('items') ? $request->input('items') : 10;

        $search = $request->input('search');

        // With search term
        if($search){
            $query = User::where('email', 'like', $search)
                ->orWhere('username', 'like', $search);
                
            $totalPages = $query->count() / $itemsPerPage;
            $users = $query->orderBy('created_at','DESC')->paginate($itemsPerPage);

            return view("user.index", compact("users",'pageNum','totalPages','itemsPerPage') );

        }
        
        // Without search term
        else {
            $totalPages = User::count() / $itemsPerPage;
            $users = User::orderBy('created_at','DESC')->paginate($itemsPerPage);

            return view("user.index", compact("users",'pageNum','totalPages','itemsPerPage') );
        }

    }

    public function show(Request $request, User $user){
        return view("user.show", compact("user") );
    }

    public function edit(Request $request, User $user){
        return view("user.edit", compact("user") );
    }

    public function update(Request $request, User $user){

        $validatedData = $request->validate([
            'username' => ['required'],
            'email' => ['required'],
            'email_verified_at' => [''],
        ]);

        $user->update($validatedData);
        return redirect()->route('User.show', [$user]);
    }
}
