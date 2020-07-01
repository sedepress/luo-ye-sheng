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
        'current_character_exp',
        'history_character_exp',
        'current_mining_exp',
        'history_mining_exp',
        'current_forging_exp',
        'history_forging_exp',
        'current_gold',
        'force',
        'intelligence',
        'defence',
        'speed',
        'equip_weapon_id',
        'equip_armor_id',
        'equip_shoes_id',
        'equip_hoe_id',
        'equip_forging_id',
        'equip_drug_id',
        'hero_id',
        'character_level',
        'mining_level',
        'forging_level',
        'invitation_code',
        'inv_num',
        'invite_people',
        'is_used_inv'
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

    public static $levelExpMap = [
        1 => self::LEVEL_TWO_REQ_EXP,
        2 => self::LEVEL_THREE_REQ_EXP,
        3 => self::LEVEL_FOUR_REQ_EXP,
        4 => self::LEVEL_FIVE_REQ_EXP,
        5 => self::LEVEL_SIX_REQ_EXP,
        6 => self::LEVEL_SEVEN_REQ_EXP,
        7 => self::LEVEL_EIGHT_REQ_EXP,
        8 => self::LEVEL_NIGHT_REQ_EXP,
        9 => self::LEVEL_TEN_REQ_EXP,
    ];

    public function props()
    {
        return $this->hasMany(UserProp::class);
    }
}
