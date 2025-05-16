<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportedProduct extends Model
{
    use HasFactory;

    public function reportedByCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'reported_by_customer_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'reported_to_product_id');
    }
}
