<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThankYouController extends Controller
{
    public function thanks(){
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->latest()->first();
        if($order){
            return Inertia::render('FrontEnd/Thankyou',['order' => $order]);
        } 
        return to_route('home');
    }
}
