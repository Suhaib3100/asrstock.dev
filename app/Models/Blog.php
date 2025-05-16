<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;
    protected $appends = ['image'];
    protected $with = ['user'];

    protected $fillable = [
        'title',
        'slug',
        'details',
        'status',
        'blog_category_id'
    ];

    public function scopeActive($query)
    {
        return $query->whereStatus(1);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute(){

        return makeFileUrl($this->fileAttach);

    }

    public function fileAttach()
    {
        return $this->morphOne(FileManager::class, 'origin');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid = Str::uuid()->toString();
            $model->user_id = auth()->id();
        });
    }
}
