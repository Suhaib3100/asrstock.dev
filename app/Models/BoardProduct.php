<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardProduct extends Model
{
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function board()
    {
        return $this->hasOne(Board::class, 'id', 'board_id');
    }
}
