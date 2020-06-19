<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'nickname',
        'openid',
        'fatigue_value',
        'lucky_value',
        'manpower',
        'current_blood_volume',
        'total_blood_volume',
        'current_exp',
        'history_exp',
        'current_gold',
        'force',
        'intelligence',
        'defence',
        'speed',
        'is_equip_weapon',
        'is_equip_armor',
        'is_equip_shoes'
    ];

    // 升级需要经验常量
    const LEVEL_TWO_REQ_EXP = 100;
    const LEVEL_THREE_REQ_EXP = 500;
    const LEVEL_FOUR_REQ_EXP = 1500;
    const LEVEL_FIVE_REQ_EXP = 4000;
    const LEVEL_SIX_REQ_EXP = 12500;
    const LEVEL_SEVEN_REQ_EXP = 30000;
    const LEVEL_EIGHT_REQ_EXP = 70000;
    const LEVEL_NIGHT_REQ_EXP = 200000;
    const LEVEL_TEN_REQ_EXP = 500000;

    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
