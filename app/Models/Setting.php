<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $appends = ['image'];

    protected $fillable = [
        'option_key'
    ];

    public function getImageAttribute(){
        if ($this->fileAttach){
            return $this->fileAttach->FileUrl;
        }
        return asset('storage/no-image.jpg');

    }

    public function fileAttach()
    {
        return $this->morphOne(FileManager::class, 'origin');
    }
}
