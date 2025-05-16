<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $appends = ['image','cover_image', 'totalProducts', 'user_follow_by_auth_customer'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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

    public function fileAttach()
    {
        return $this->morphOne(FileManager::class, 'origin');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getTotalProductsAttribute()
    {
        return $this->hasMany(Product::class)->where('status', PRODUCT_STATUS_PUBLISHED)->count();
    }
    public function getUserFollowByAuthCustomerAttribute()
    {
        $customer_id = \Illuminate\Support\Facades\Auth::guard('api')->id();
        $check = Following::where('following_user_id', $this->id)->where('customer_id', $customer_id)->first();
        if ($check) {
            return true;
        }
        return false;
    }

    public function followers()
    {
        return $this->hasMany(Following::class, 'following_user_id');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid = Str::uuid()->toString();
        });
    }
}
