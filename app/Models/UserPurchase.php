<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPurchase extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'variations_id',
        'customer_id',
        'owner_id',
        'owner_type',
        'licence',
        'price',
    ];

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}
