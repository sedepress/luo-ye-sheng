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
        'equip_belt_id',
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
        'is_used_inv',
        'is_subscribe'
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

    // 升级所需人力值
    const LEVEL_TWO_MANPOWER = 1;
    const LEVEL_THREE_MANPOWER = 2;
    const LEVEL_FOUR_MANPOWER = 3;
    const LEVEL_FIVE_MANPOWER = 4;
    const LEVEL_SIX_MANPOWER = 5;
    const LEVEL_SEVEN_MANPOWER = 6;
    const LEVEL_EIGHT_MANPOWER = 7;
    const LEVEL_NIGHT_MANPOWER = 8;
    const LEVEL_TEN_MANPOWER = 9;

    // 等级类型
    const LEVEL_TYPE_CHARACTER = 1;
    const LEVEL_TYPE_MINING = 2;
    const LEVEL_TYPE_FORGING = 3;

    // 邀请人奖励需要等级
    const INV_LEVEL_ONE = 1;
    const INV_LEVEL_THREE = 3;
    const INV_LEVEL_FIVE = 5;

    // 疲劳购买量
    const BUY_FATIGUE = 10;

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

    public static $levelNeedManpowerMap = [
        1 => self::LEVEL_TWO_MANPOWER,
        2 => self::LEVEL_THREE_MANPOWER,
        3 => self::LEVEL_FOUR_MANPOWER,
        4 => self::LEVEL_FIVE_MANPOWER,
        5 => self::LEVEL_SIX_MANPOWER,
        6 => self::LEVEL_SEVEN_MANPOWER,
        7 => self::LEVEL_EIGHT_MANPOWER,
        8 => self::LEVEL_NIGHT_MANPOWER,
        9 => self::LEVEL_TEN_MANPOWER,
    ];

    public static $levelFieldMap = [
        self::LEVEL_TYPE_CHARACTER => 'character_level',
        self::LEVEL_TYPE_MINING    => 'mining_level',
        self::LEVEL_TYPE_FORGING   => 'forging_level',
    ];

    public static $invLevelMap = [
        self::INV_LEVEL_ONE => 1,
        self::INV_LEVEL_THREE => 3,
        self::INV_LEVEL_FIVE => 6,
    ];

    public function props()
    {
        return $this->hasMany(UserProp::class);
    }
}
