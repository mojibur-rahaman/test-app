<?php

namespace App\Http\Controllers;
use DB;
use Inertia\Inertia;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class FrontEndController extends Controller
{
    public function index(){    
        // Count the products ordered and order by quantity sold
        $bestSellingProducts = DB::table('order_details')
        ->select('product_id', \DB::raw('SUM(qty) as total_sold'))
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->limit(10) 
        ->get(); 
        // Fetch the actual products from the products table
        $pk_products = Product::with('images')->where('status',1)->where('category','PK')->limit(5)->get();
        $na_products = Product::with('images')->where('status',1)->where('category','NA')->limit(10)->get();
        $mp_products = Product::with('images')->where('status',1)->where('category','MP')->limit(10)->get();
        $bs_products = Product::with('images')->where('status',1)->whereIn('id', $bestSellingProducts->pluck('product_id'))->get();
        $mix_products = Product::inRandomOrder()->with('images')->where('status',1)->limit(20)->get();
        $mobileBanners = Banner::where('placement','mobile')->get();
        $desktopBanners = Banner::where('placement','desktop')->get(); 
        return Inertia::render('Welcome',[
            'pk_products'=>$pk_products,
            'na_products'=>$na_products,
            'mp_products'=>$mp_products,
            'bs_products'=>$bs_products,
            'mix_products'=>$mix_products, 
            'mobileBanners' =>$mobileBanners,
            'desktopBanners' =>$desktopBanners,
        ]); 
    }
    
    public function prodcutView($slug)
    {
        $product = Product::with('images')->where('slug', $slug)->first();
        if($product){
                $relatedProducts = Product::with('images')
                ->where('category', $product->category)
                ->where('status', 1)
                ->limit(10)
                ->get();
        
            return Inertia::render('FrontEnd/ProductView', [
                'product' => $product,
                'relatedProducts' => $relatedProducts
            ]);
        }
    
        return to_route('home');
    }
}
