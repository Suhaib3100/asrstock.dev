<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $appends = ['image'];

    public function getImageAttribute(){
      return makeFileUrl($this->fileAttach);
    }

    public function fileAttach()
    {
        return $this->morphOne(FileManager::class, 'origin');
    }
}
