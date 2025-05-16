<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    protected $guarded = [];
    protected $casts = [
        'gateway_parameters' => 'object',
        'user_proof_param' => 'array'
    ];

    public function scopeActive($query)
    {
        return $query->whereStatus(ACTIVE);
    }

}
