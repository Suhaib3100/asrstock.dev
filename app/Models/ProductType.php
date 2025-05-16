<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductType extends Model
{
    use HasFactory;
    protected $appends = ['icon'];
    protected $guarded = [];
    protected $with = ['categories'];

    public function scopeActive($query)
    {
        return $query->whereStatus(1);
    }

    public function categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function product_type_extensions()
    {
        return $this->belongsToMany(ProductTypeExtension::class, 'product_type_product_type_extension', 'product_type_id', 'product_type_extension_id');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
            $model->slug =  getSlug($model->name);
        });
    }
    public function getIconAttribute(){

        return makeFileUrl($this->fileAttach);
    }

    public function fileAttach()
    {
        return $this->morphOne(FileManager::class, 'origin');
    }
}
