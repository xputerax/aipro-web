<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'address', 'phone', 'email',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
