<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTypeExtension extends Model
{
    protected $fillable = [
        'product_type_category',
        'name',
        'status',
    ];
}
