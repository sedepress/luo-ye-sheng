<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function getShopDescAttribute()
    {
        if ($this->price_type == 1) {
            return '价格' . $this->price . '人力值';
        } else {
            return '价格' . $this->price . '金币';
        }
    }
}
