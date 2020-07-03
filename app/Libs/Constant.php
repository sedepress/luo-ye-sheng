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

    const GET_EXP_LEVEL_ONE = 5;
    const GET_EXP_LEVEL_TWO = 10;
    const GET_EXP_LEVEL_THREE = 15;
    const GET_EXP_LEVEL_FOUR = 25;
    const GET_EXP_LEVEL_FIVE = 40;
    const GET_EXP_LEVEL_SIX = 70;
    const GET_EXP_LEVEL_SEVEN = 100;
    const GET_EXP_LEVEL_EIGHT = 130;
    const GET_EXP_LEVEL_NINE = 160;
    const GET_EXP_LEVEL_TEN = 250;

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

    public static $equipGroup = [
        self::EQUIP_TYPE_WEAPON,
        self::EQUIP_TYPE_ARMOR,
        self::EQUIP_TYPE_SHOES,
        self::EQUIP_TYPE_BELT,
    ];

    public static $getExpLevelMap = [
        1  => self::GET_EXP_LEVEL_ONE,
        2  => self::GET_EXP_LEVEL_TWO,
        3  => self::GET_EXP_LEVEL_THREE,
        4  => self::GET_EXP_LEVEL_FOUR,
        5  => self::GET_EXP_LEVEL_FIVE,
        6  => self::GET_EXP_LEVEL_SIX,
        7  => self::GET_EXP_LEVEL_SEVEN,
        8  => self::GET_EXP_LEVEL_EIGHT,
        9  => self::GET_EXP_LEVEL_NINE,
        10 => self::GET_EXP_LEVEL_TEN,
    ];
}
