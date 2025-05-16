<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrustedBrand extends Model
{

    protected $appends = ['image'];

    public function getLogoAttribute()
    {
        return getFileUrl($this->image);
    }
}
