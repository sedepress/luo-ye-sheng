<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'hero_id',
        'force',
        'intelligence',
        'defence',
        'speed',
        'is_equip_weapon',
        'is_equip_armor',
        'is_equip_shoes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
