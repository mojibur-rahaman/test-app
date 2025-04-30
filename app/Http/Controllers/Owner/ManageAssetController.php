<?php

namespace App\Http\Controllers\Owner;

use Inertia\Inertia;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageAssetController extends Controller
{
    public function index(){
        $mobileBanners = Banner::where('placement','mobile')->get(); 
        $desktopBanners = Banner::where('placement','desktop')->get(); 
        return Inertia::render('Owner/Asset',[
            'mobileBanners'=>$mobileBanners,
            'desktopBanners'=>$desktopBanners,

        ]);  
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'image' => 'required|file|mimes:gif,jpeg,png,jpg,webp|max:4096', 
            'placement' => 'required',
        ]);
         // Inset Product Images ----------------------------------->

         if($validatedData['image']){  
            $path='upload/asset/'; 
            
            $ext=$validatedData['image']->getClientOriginalExtension();
            $fileName = time().'.'.$ext;
            $validatedData['image']->move($path,$fileName);
             
            Banner::create([
                'image' => $fileName,
                'placement' => $validatedData['placement'],
            ]);
            return to_route('owner.asset.index');
        } 
        return to_route('owner.asset.index');
    }

    public function removeBanner(Request $request){
        $banner = Banner::findOrFail($request->bannerId); 

        // Optionally delete the image file
        $imagePath = public_path('upload/asset/' . $banner->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $banner->delete(); 

        return to_route('owner.asset.index');
    }
}
