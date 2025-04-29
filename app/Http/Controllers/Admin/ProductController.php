<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductsImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductValidationRequest;

class ProductController extends Controller
{
    /**
     * index all Product
     * @var object
     * Required
     */
    public function index(){ 
        $products = Product::with('images')->inRandomOrder()->paginate(20); 
        return Inertia::render('Admin/Product',['products'=> $products]); 
    }
    /**
     * Create a Product
     */
    public function create(){
        return Inertia::render('Admin/AddProduct');
    }
    /**
     * store product data in database
     */
    
    public function store(ProductValidationRequest $request) { 
        $validatedData = $request->validated();
        // dd($validatedData);

        if($validatedData){
            // Inset Product Information ----------------------------------->
          $product = Product::create([
                'name' => $validatedData['productName'],
                'price' => $validatedData['productPrice'],
                'weight' => $validatedData['productWeight'],
                'weightDesc' => $validatedData['productWeightDesc'],
                'category' => $validatedData['productCategory'],
                'maxQuantity' => $validatedData['productMaxQuantity'],
                'metaTitle' => $validatedData['metaTitle'],
                'metaKeyword' => $validatedData['metaKeyword'],
                'metaDescription' => $validatedData['metaDescription'],
                'sortDesc' => $validatedData['productSortDesc'],
                'longDesc' => $validatedData['productLongDesc'],
                'status' => $validatedData['productStatus'],
           ]); 

           // Inset Product Images ----------------------------------->

            if($validatedData['productImages']){ 
                
                $path='upload/products/';
                $i=1;
                
                foreach ($validatedData['productImages'] as $imageData) { 
                    if (isset($imageData['file'])) {
                        $ext=$imageData['file']->getClientOriginalExtension();
                        $fileName = time().$i++.'.'.$ext;
                        $imageData['file']->move($path,$fileName);
                        $product->images()->create([
                            'product_id' => $product->id,
                            'image' => $fileName  
                        ]);
                    } 
                }  
            }  
            return to_route('admin.products.index');

        } 
        return redirect()->back();
    }

    /**
     * edit an existing product
     */
    public function edit($product_id){  
        $product = Product::with('images')->findOrFail($product_id);
        if($product)
        {
            return Inertia::render('Admin/EditProduct',['product' => $product]);
        }else{
            return redirect()->back();
        }
        return $product; 
    }

    /**
     * Update an existing product
     */
    public function update(ProductValidationRequest $request, $product_id)
    {
        $validatedData = $request->validated();   
        $product = Product::with('images')->findOrFail($product_id);
        $imageCounter = ProductsImage::where('product_id', '=',$product_id)->count();  
        // Update product details
        $product->name = $validatedData['productName'];
        $product->price = $validatedData['productPrice'];
        $product->weight = $validatedData['productWeight'];
        $product->weightDesc = $validatedData['productWeightDesc'];
        $product->category = $validatedData['productCategory'];
        $product->maxQuantity = $validatedData['productMaxQuantity'];
        $product->metaTitle = $validatedData['metaTitle'];
        $product->metaKeyword = $validatedData['metaKeyword'];
        $product->metaDescription = $validatedData['metaDescription'];
        $product->sortDesc = $validatedData['productSortDesc'];
        $product->longDesc = $validatedData['productLongDesc'];
        $product->status = $validatedData['productStatus'];
        $product->save(); // Save updated product details

        // Define upload path
        $path = 'upload/products/';

        // Insert new product images
        if($imageCounter <= 2){
            if (!empty($validatedData['backendImages'])) {
                $i = 1;
                foreach ($validatedData['backendImages'] as $imageData) {
                    if (isset($imageData['file'])) {
                        $ext = $imageData['file']->getClientOriginalExtension();
                        $fileName = time() . $i++ . '.' . $ext;
        
                        // Move the uploaded file
                        $imageData['file']->move(public_path($path), $fileName);
        
                        // Store image reference in the database
                        $product->images()->create([
                            'product_id' => $product->id,
                            'image' => $fileName
                        ]);
                    }
                }
            }
        } 
        
        // Delete existing images
        if (!empty($validatedData['deletedImagesIds'])) { 
            if($imageCounter != 0){
                foreach ($validatedData['deletedImagesIds'] as $imageId) {
                    $image = ProductsImage::find($imageId);
                    if ($image) {
                        $imagePath = public_path($path . $image->image); 
                        // Check if the file exists before deleting
                        if (File::exists($imagePath)) {
                            File::delete($imagePath);
                        } 
                        // Delete from the database
                        $image->delete();
                    }
                }
            } 
        }

        // Return a success response for Inertia.js
        return to_route('admin.products.index');
    }

    /**
     * remove product form database
     * @var id interger
     */
}
