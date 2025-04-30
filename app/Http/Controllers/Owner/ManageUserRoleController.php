<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ManageUserRoleController extends Controller
{
    public function index(){ 
        $users = User::latest()->paginate(30);  
        return Inertia::render('Owner/AppUser',['users' => $users]); 
    }

    public function create(){
        return Inertia::render('Owner/CreateUser'); 
    }

    public function edit($user_id){ 
        $user = User::findOrFail($user_id);  
        return Inertia::render('Owner/EditUser',['user' => $user]); 
    } 

    public function store(Request $request) { 
        $validatedData = $request->validate([
                            'name' => 'required|string',
                            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
                            'role' => 'required|string',
                            'password' => 'required|confirmed|min:8', 
                        ]);    
        if($validatedData){
          // Inset User Information ----------------------------------->
          User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'role' => $validatedData['role'], 
                'password' => Hash::make($validatedData['password']), 
           ]);  
           // Inset Product Images ------------------------------------------> 
            return to_route('owner.user.index');
        } 
        return redirect()->back();
    }

    public function update(Request $request, User $user_id){
        $validatedData =$request->validate([
                            'name' => 'required|string',
                            'email' => 'required|email',
                            'role' => 'required|string',
                        ]); 
        $user_id->update(['role' => $validatedData['role']]);
        return to_route('owner.dashboard');
    }
}
