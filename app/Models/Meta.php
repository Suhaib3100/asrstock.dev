<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Meta extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'page_type',
        'slug',
        'page_name',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];


    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
