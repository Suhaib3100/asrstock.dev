<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'description',
        'status',
        'uploaded_by',
        'accessibility',
        'is_featured',
        'use_this_photo',
        'thumbnail_image_id',
        'play_file',
        'file_types',
        'product_type_id',
        'product_category_id',
        'customer_id',
        'user_id',
        'tax_id',
        'total_watch',
        'attribution_required',
    ];

    protected $appends = ['thumbnail_image', 'main_file', 'favourite_by_auth_customer','content_type', 'play_link'];
    protected $with = ['user', 'customer'];

    public function scopePublished($query)
    {
        return $query->whereStatus(PRODUCT_STATUS_PUBLISHED);
    }

    public function scopePending($query)
    {
        return $query->whereStatus(PRODUCT_STATUS_PENDING);
    }

    public function scopeHold($query)
    {
        return $query->whereStatus(PRODUCT_STATUS_HOLD);
    }

    public function scopeIsFeatured($query)
    {
        return $query->where('is_featured',PRODUCT_IS_FEATURED_YES);
    }

    public function scopePaid($query)
    {
        return $query->where('accessibility',PRODUCT_ACCESSIBILITY_PAID);
    }

    public function scopeFree($query)
    {
        return $query->where('accessibility',PRODUCT_ACCESSIBILITY_FREE);
    }

    public function getContentTypeAttribute(){
        return getProductTypeCategorySlug($this->productType->product_type_category);
    }

    public function getThumbnailImageAttribute(){
        return makeFileUrl($this->fileAttachThumbnail);
    }

    public function getPlayLinkAttribute(){
        return makeFileUrl($this->playFileAttachment);
    }

    public function fileAttachThumbnail()
    {
        return $this->hasOne(FileManager::class, 'id', 'thumbnail_image_id');
    }

    public function getMainFileAttribute(){
        return makeFileUrl($this->fileAttach);
    }

    public function playFileAttachment(){
        return $this->belongsTo(FileManager::class, 'play_file', 'id');
    }

    public function fileAttach(): MorphOne
    {
        return $this->morphOne(FileManager::class, 'origin');
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function productTags()
    {
        return $this->hasMany(ProductTag::class, 'product_id');
    }

    public function comments()
    {
        return $this->hasMany(ProductComment::class, 'product_id');
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function downloadProducts(): HasMany
    {
        return $this->hasMany(DownloadProduct::class, 'product_id');
    }

    public function favouriteProducts(): HasMany
    {
        return $this->hasMany(FavouriteProduct::class, 'product_id');
    }

    public function getFavouriteByAuthCustomerAttribute()
    {
        $customer_id = \Illuminate\Support\Facades\Auth::guard('api')->id();
        $check = FavouriteProduct::where('product_id', $this->id)->where('customer_id', $customer_id)->first();
        if ($check) {
            return true;
        }
        return false;
    }


    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeUploadedByAdmin($query)
    {
        return $query->whereUploadedBy(PRODUCT_UPLOADED_BY_ADMIN);
    }

    public function scopeUploadedByContributor($query)
    {
        return $query->whereUploadedBy(PRODUCT_UPLOADED_BY_CONTRIBUTOR);
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid = Str::uuid()->toString();
        });
    }
}
