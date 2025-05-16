<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tax extends Model
{
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->whereStatus(ACTIVE);
    }
}
