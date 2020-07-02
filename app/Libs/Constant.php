<?php


namespace App\Libs;


class Constant
{
    const EQUIP_TYPE_WEAPON = 1;
    const EQUIP_TYPE_ARMOR = 2;
    const EQUIP_TYPE_SHOES = 3;
    const EQUIP_TYPE_BELT = 4;
    const EQUIP_TYPE_HOE = 5;
    const EQUIP_TYPE_FORGING = 6;
    const EQUIP_TYPE_ORE = 7;
    const EQUIP_TYPE_DRUP = 8;

    public static $equipTypeMap = [
        self::EQUIP_TYPE_WEAPON  => '武器',
        self::EQUIP_TYPE_ARMOR   => '护甲',
        self::EQUIP_TYPE_SHOES   => '鞋子',
        self::EQUIP_TYPE_BELT    => '腰带',
        self::EQUIP_TYPE_HOE     => '锄头',
        self::EQUIP_TYPE_FORGING => '锻造炉',
        self::EQUIP_TYPE_ORE     => '矿石',
        self::EQUIP_TYPE_DRUP    => '药品',
    ];
}
