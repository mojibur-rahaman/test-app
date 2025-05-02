<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchProduct(Request $request)
    {
        $validated = $request->validate([
            'query'       => 'required|string|max:255'  
        ]);  
        $products = Product::with('images')->when($request->query('query'), function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->query('query') . '%')
                  ->orWhere('en_name','LIKE', '%' . $request->query('query') . '%');
        })->get(); 
        
        return Inertia::render('FrontEnd/Search', ['products' => $products,'query' => $request['query']]);
    }

    public function adminSearch(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string|max:255',
            't'     => 'required|string|max:15',
        ]);

        $allowedTables = ['products', 'orders', 'users'];
        $type = $validated['t'];
        $query = $validated['query'];

        if (!in_array($type, $allowedTables)) {
            return to_route('admin.dashboard');
        }

        switch ($type) {
            case 'orders':
                $results = Order::where('id', 'LIKE', "%$query%")
                    ->orWhere('mobile', 'LIKE', "%$query%")
                    ->orWhere('address', 'LIKE', "%$query%")
                    ->orWhere('name', 'LIKE', "%$query%")
                    ->paginate(20);
                break;

            case 'products':
                $results = Product::with('images')->where('name', 'LIKE', "%$query%")
                    ->orWhere('longDesc', 'LIKE', "%$query%")
                    ->paginate(20);
                break;

            case 'users':
                $results = User::where('name', 'LIKE', "%$query%")
                    ->orWhere('email', 'LIKE', "%$query%")
                    ->orWhere('mobile', 'LIKE', "%$query%")
                    ->paginate(20);
                break;

            default:
                $results = collect();
        }

        return Inertia::render('Admin/AdminSearch', [
            'results' => $results,
            'query'   => $query,
            'type'    => $type
        ]);
    }
}
