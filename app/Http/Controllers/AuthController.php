<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return Inertia::render('FrontEnd/Login');
    }

    public function registerOrLogin(Request $request){
        // validate
        $mobile = $request->validate([
            'mobile' => ['required','string','max:11'],
        ]); 
        // create account
        $user = User::where('mobile' ,'=',$mobile['mobile'])->first();
        if($user){
            Auth::login($user);  
        }else{
            $newUser = User::create([
                'mobile' => $mobile['mobile'],
            ]); 
            Auth::login($newUser); 
        } 
        // redirect to dashboard page 
        return to_route('home');
    }

    public function adminIndex(){
        $customers = User::where('role',0)->latest()->paginate(30);  
        return Inertia::render('Admin/User',['customers' => $customers]); 
    }
}
