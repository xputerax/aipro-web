<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name', 'description', 'branch_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function models()
    {
        return $this->hasMany(ProductModel::class);
    }
}
