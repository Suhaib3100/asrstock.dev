<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiary extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'beneficiary_id',
        'customer_id',
        'name',
        'type',
        'details',
        'status',
    ];
}
