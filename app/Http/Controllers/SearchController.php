<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
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
            $query->where('name', 'LIKE', '%' . $request->query('query') . '%');
        })->get(); 
        
        return Inertia::render('FrontEnd/Search', ['products' => $products,'query' => $request['query']]);
    }
}
