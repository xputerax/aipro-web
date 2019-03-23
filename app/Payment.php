<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'order_payments';

    protected $fillable = [
        'branch_id', 'customer_id', 'order_id', 'amount', 'deposit', 'created_at'
    ];

    protected $attributes = [
        'deposit' => 0,
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
