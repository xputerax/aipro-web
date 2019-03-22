<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $rememberTokenName = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'username', 'full_name', 'password', 'group_id', 'branch_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
