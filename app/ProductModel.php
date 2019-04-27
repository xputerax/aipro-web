<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'product_models';

    protected $fillable = [
        'branch_id', 'brand_id', 'name', 'description', 'created_at', 'updated_at'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'model_id', 'id');
    }
}
