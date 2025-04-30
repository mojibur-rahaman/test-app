<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrdersDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
{
    public function index() {
        return Inertia::render('FrontEnd/CheckOut');
    }

    public function store(Request $request) {
        // Validating Frontend Data
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'mobile'     => ['required', 'string', 'regex:/^01(?!0|1|2)\d{9}$/'],
            'address'    => 'required|string|max:255', 
            'total'      => 'required',
            'products'   => 'required|array',
        ]); 

        try {
            DB::beginTransaction(); // Start Transaction

            // Create or find user
            $user = User::firstOrCreate([
                'mobile' => $validated['mobile'], 
            ]); 

            // Create order
            $order = Order::create([
                'user_id'      => $user->id,
                'name'         => $validated['name'],
                'mobile'       => $validated['mobile'],
                'address'      => $validated['address'], 
                'total'        => $validated['total'],
                'order_status' => 'pending',
                'payment_type' => 'cod',
            ]);

            // Create order details
            foreach ($validated['products'] as $product) {
                OrdersDetail::create([
                    'order_id'   => $order->id,  
                    'product_id' => $product['id'],
                    'qty'        => $product['quantity'], 
                ]);
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack(); // Rollback in case of error
            dd($e);
            return redirect()->back()->withErrors(['message' => 'Something went wrong!']);
        }
        Auth::login($user);
        return to_route('user.thankyou');
    }
}
