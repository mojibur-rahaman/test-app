<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsImage extends Model
{
    // database table  //
    protected $table = 'products_images';
    protected $fillable = [
        'product_id',
        'image', 
    ];
}
