<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanGatewayPrice extends Model
{
    protected $fillable = [
        'plan_id',
        'gateway_id',
        'gateway',
        'monthly_price_id',
        'yearly_price_id',
        'status',
    ];
}
