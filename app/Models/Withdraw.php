<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Withdraw extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'customer_id',
        'beneficiary_id',
        'beneficiary_details',
        'amount',
        'customer_note',
        'cancel_reason',
        'status',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function scopePending($query)
    {
        return $query->whereStatus(WITHDRAW_STATUS_PENDING);
    }

    public function scopeCompleted($query)
    {
        return $query->whereStatus(WITHDRAW_STATUS_COMPLETED);
    }

    public function scopeCancelled($query)
    {
        return $query->whereStatus(WITHDRAW_STATUS_CANCELLED);
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
