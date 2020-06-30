<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProp extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'lower',
        'upper',
        'type',
        'shop_id',
        'is_equip',
        'remaining_usage',
        'status',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
