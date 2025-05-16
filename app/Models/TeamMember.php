<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $appends = ['image'];

    public function getImageAttribute()
    {
        return makeFileUrl($this->fileAttach);
    }

    public function fileAttach()
    {
        return $this->morphOne(FileManager::class, 'origin');
    }
}
