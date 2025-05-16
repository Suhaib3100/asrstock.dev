<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletMoney extends Model
{
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopePaid($query)
    {
        return $query->where('status', WALLET_MONEY_STATUS_PAID);
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_name', 'gateway_slug');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', WALLET_MONEY_STATUS_PENDING);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', WALLET_MONEY_STATUS_CANCELLED);
    }
}
