<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){   
        $orders = Order::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->latest()
        ->paginate(45);
        return Inertia::render('Admin/Order',['orders'=> $orders]); 
    }
    public function edit($order_id){
        $order = Order::with('items.product.images')->find($order_id); 
        return Inertia::render('Admin/UpdateOrder',['order' => $order]);
    }
    public function update(Request $request, Order $order_id)
    {
        $request->validate(['orderStatus' => 'required|string']);
        $order_id->update(['order_status' => $request->orderStatus]);
        return redirect('/admin/orders');
    }
}
