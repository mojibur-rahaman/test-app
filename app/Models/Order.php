<?php

namespace App\Models;

use App\Models\OrdersDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'address', 
        'total',
        'order_status',
        'payment_type'
    ]; 

    /**
     * return order list user order id
     */
    public function items() : HasMany
    {
        return $this->hasMany(OrdersDetail::class,'order_id','id');
    } 
}
