<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportedMember extends Model
{
    use HasFactory;

    public function reportedByCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'reported_by_customer_id');
    }

    public function reportedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_to_user_id');
    }

    public function reportedToCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'reported_to_customer_id');
    }
}
