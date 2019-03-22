<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    protected $table = 'order_products';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
