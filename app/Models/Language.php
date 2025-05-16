<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $appends = ['url', 'flag'];
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->whereStatus(ACTIVE);
    }

    public function getUrlAttribute()
    {
        $path = resource_path()."/resources/lang/$this->iso_code.json";
        return $path;
    }

    public function getFlagAttribute(){

        return makeFileUrl($this->fileAttach);

    }

    public function fileAttach()
    {
        return $this->morphOne(FileManager::class, 'origin');
    }
}
