<?php

namespace App\Models;

use App\Libs\Constant;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function userProps()
    {
        return $this->hasMany(UserProp::class);
    }

    public function getShopDescAttribute()
    {
        $str = '价格' . $this->price;
        if ($this->price_type == 1) {
            $str .= '人力值';
        } else {
            $str .= '金币';
        }

        switch ($this->type) {
            case Constant::EQUIP_TYPE_WEAPON:
                $str .= sprintf(" 攻击范围%d ~ %d", $this->lower, $this->upper);
                break;
            case Constant::EQUIP_TYPE_ARMOR:
                $str .= sprintf(" %d点护甲", $this->lower);
                break;
            case Constant::EQUIP_TYPE_SHOES:
                $str .= sprintf(" %d点速度", $this->lower);
                break;
            case Constant::EQUIP_TYPE_HOE:
                $str .= sprintf(" %d次使用次数", $this->lower);
                break;
            case Constant::EQUIP_TYPE_FORGING:
                $str .= sprintf(" %d次使用次数", $this->lower);
                break;
            case Constant::EQUIP_TYPE_DRUP:
                $str .= sprintf(" %d点补充量", $this->lower);
                break;
        }

        return $str;
    }
}
