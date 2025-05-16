<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Customer extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $appends = ['image', 'cover_image', 'totalProducts', 'name'];
    protected $guarded = [];
    protected $hidden = [
        'password',
    ];

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getCoverImageAttribute(): string
    {
        return makeFileUrl($this->fileAttachCover);
    }

    public function fileAttachCover(): HasOne
    {
        return $this->hasOne(FileManager::class, 'id', 'cover_image_id');
    }

    public function getImageAttribute(): string
    {
        return makeFileUrl($this->fileAttach);
    }

    public function fileAttach(): MorphOne
    {
        return $this->morphOne(FileManager::class, 'origin');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function withdraws(): HasMany
    {
        return $this->hasMany(Withdraw::class);
    }

    public function getTotalProductsAttribute(): int
    {
        return $this->hasMany(Product::class)->where('status', PRODUCT_STATUS_PUBLISHED)->count();
    }

    public function scopeCustomer($query)
    {
        return $query->whereRole(CUSTOMER_ROLE_CUSTOMER);
    }

    public function scopeContributor($query)
    {
        return $query->whereRole(CUSTOMER_ROLE_CONTRIBUTOR);
    }

    public function scopeContributorApplyYes($query)
    {
        return $query->whereContributorApply(CONTRIBUTOR_APPLY_YES);
    }

    public function scopeContributorApplyNo($query)
    {
        return $query->whereContributorApply(CONTRIBUTOR_APPLY_NO);
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(ACTIVE);
    }

    public function scopeDisable($query)
    {
        return $query->whereStatus(DISABLE);
    }

    public function scopePending($query)
    {
        return $query->whereStatus(PENDING);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

   public function followers()
    {
        return $this->hasMany(Following::class, 'following_customer_id');
    }

    public function followings()
    {
        return $this->hasMany(Following::class, 'customer_id');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
