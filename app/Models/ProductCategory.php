<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_type_id',
        'slug',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->whereStatus(ACTIVE);
    }

    public function scopeDisable($query)
    {
        return $query->whereStatus(DISABLE);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class)->published();
    }
    public function product()
    {
        return $this->hasOne(Product::class)->published()->latest();
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
