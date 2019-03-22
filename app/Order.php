<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{

    protected $attributes = [
        'resolve_user_id' => null,
        'delivery_user_id' => null,
        'resolved_at' => null,
        'delivered_at' => null,
        'deposit' => '0.00'
    ];

    protected $dates = [
        'checkout_at', 'resolved_at', 'delivered_at', 'created_at', 'updated_at'
    ];

    protected $fillable = [
        'status', 'deposit', 'checkout_at', 'resolved_at', 'delivered_at', 'resolve_user_id', 'delivery_user_id'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function checkout_user()
    {
        return $this->belongsTo(User::class);
    }

    public function resolve_user()
    {
        return $this->belongsTo(User::class);
    }

    public function delivery_user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderProduct::class, 'product_id', 'id');
    }

    public function getTotalPriceAttribute()
    {
        return $this->select(DB::raw('sum(quantity * price) as sum_price'))
                    ->from('order_products')
                    ->where('order_products.order_id', $this->id)
                    ->first()
                    ->sum_price;
    }

    public function getTotalPriceAfterDepositAttribute()
    {
        $calculated = $this->total_price - $this->deposit;
        return sprintf("%.2f", $calculated);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
