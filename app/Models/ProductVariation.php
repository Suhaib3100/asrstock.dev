<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = [
        'product_id',
        'variation',
        'price',
        'file',
        'status',
        'updated_at',
    ];

    protected $appends = ['file_path'];

    public function getFilePathAttribute(){
       return getFileFromManager($this->file);
    }
}
