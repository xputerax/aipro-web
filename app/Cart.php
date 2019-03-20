<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'branch_id', 'customer_id', 'product_id', 'price', 'quantity', 'description',
    ];

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
    public function getTotalPriceAttribute()
    {
        $total_price = $this->quantity * $this->price;

        return sprintf('%.2f', $total_price);
    }
}
