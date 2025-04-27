<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdersDetail extends Model
{
    protected $table = 'order_details';
    protected $fillable = [
        'order_id',
        'product_id',
        'qty'
    ]; 

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
