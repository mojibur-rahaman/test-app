<?php

namespace App\Models;

use App\Models\ProductsImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{ 
     protected $table = 'products';
     protected $fillable = [
            'name',
            'price',
            'weight',
            'weightDesc',
            'category',
            'maxQuantity',
            'metaTitle',
            'metaKeyword',
            'metaDescription',
            'sortDesc',
            'longDesc',
            'status',
     ]; 

     // product Images // 
     public function images() : HasMany
     {
          return $this->hasMany(ProductsImage::class,'product_id', 'id');
     }
} 
