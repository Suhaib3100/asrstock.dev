<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'gateway_transaction',
        'payment_id',
        'customer_id',
        'plan_id',
        'plan_price',
        'plan_duration_type',
        'product_id',
        'variation_id',
        'product_price',
        'donate_price',
        'coupon_id',
        'coupon_discount_type',
        'coupon_discount_value',
        'tax_id',
        'tax_percentage',
        'current_currency',
        'gateway_id',
        'gateway_currency',
        'conversion_rate',
        'admin_commission',
        'contributor_commission',
        'subtotal',
        'discount',
        'tax_amount',
        'total',
        'grand_total',
        'payment_status',
        'payment_type',
        'bank_name',
        'bank_id',
        'bank_account_number',
        'deposit_by',
        'bank_deposit_slip',
        'type',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }

    public function referralHistory(): HasOne
    {
        return $this->hasOne(ReferralHistory::class);
    }

    public function customerPlan(): HasOne
    {
        return $this->hasOne(CustomerPlan::class);
    }

    public function scopePending($query)
    {
        return $query->wherePaymentStatus(ORDER_PAYMENT_STATUS_PENDING);
    }

    public function scopePaid($query)
    {
        return $query->wherePaymentStatus(ORDER_PAYMENT_STATUS_PAID);
    }

    public function scopeCancelled($query)
    {
        return $query->wherePaymentStatus(ORDER_PAYMENT_STATUS_CANCELLED);
    }

    public function scopeBank($query)
    {
        return $query->wherePaymentType(ORDER_PAYMENT_TYPE_BANK);
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->order_number = Str::uuid()->getHex();
        });
    }
}
