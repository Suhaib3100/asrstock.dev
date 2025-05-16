<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Plan extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'subtitle',
        'description',
        'slug',
        'monthly_price',
        'yearly_price',
        'device_limit',
        'download_limit_type',
        'download_limit',
        'tax_id',
        'status',
    ];

    public function subscriptionPrice()
    {
        return $this->hasMany(PlanGatewayPrice::class, 'plan_id', 'id');
    }

    public function planBenefits()
    {
        return $this->hasMany(PlanBenefit::class, 'plan_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(ACTIVE);
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
