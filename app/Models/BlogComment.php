<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;
    protected $with = ['customer', 'blogCommentReplies'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function blogCommentReplies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(1);
    }
}
