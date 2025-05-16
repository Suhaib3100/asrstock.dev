<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    use HasFactory;

    public function followingCustomer()
    {
        return $this->belongsTo(Customer::class, 'following_customer_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function followingUser()
    {
        return $this->belongsTo(User::class, 'following_user_id');
    }

    public function contributorFollowers()
    {
        return $this->hasMany(Customer::class, 'id', 'following_customer_id');
    }

    public function userFollowers()
    {
        return $this->hasMany(User::class, 'id', 'following_user_id');
    }

    public function contributorProducts()
    {
        return $this->hasMany(Product::class, 'customer_id', 'following_customer_id');
    }

    public function userProducts()
    {
        return $this->hasMany(Product::class, 'user_id', 'following_user_id');
    }
}
