<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }

    public function getTotalPriceAttribute()
    {
        $total_price = $this->quantity * $this->price;

        return sprintf('%.2f', $total_price);
    }

    // public function getTotalCartPriceAttribute()
    // {
    //     return static::query()
    //                 ->select(DB::raw('sum(quantity * price) as sum_cart_price'))
    //                 // ->where('customer_id', '=', $this->customer_id)
    //                 ->first()
    //                 ->sum_cart_price;
    // }
}
