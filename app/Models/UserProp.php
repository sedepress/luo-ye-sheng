<?php

namespace App\Models;

use App\Libs\Constant;
use Illuminate\Database\Eloquent\Model;

class UserProp extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'lower',
        'upper',
        'rating',
        'type',
        'shop_id',
        'status',
    ];

    public function getPropDescAttribute()
    {
        $str = '';

        switch ($this->type) {
            case Constant::EQUIP_TYPE_WEAPON:
                $str .= sprintf(" 攻击范围%d ~ %d", $this->lower, $this->upper);
                break;
            case Constant::EQUIP_TYPE_ARMOR:
                $str .= sprintf(" %d点防御", $this->lower);
                break;
            case Constant::EQUIP_TYPE_SHOES:
                $str .= sprintf(" %d点速度", $this->lower);
                break;
            case Constant::EQUIP_TYPE_BELT:
                $str .= sprintf(" %d点血量", $this->lower);
                break;
            case Constant::EQUIP_TYPE_HOE:
                $str .= sprintf(" %d次剩余次数", $this->lower);
                break;
            case Constant::EQUIP_TYPE_FORGING:
                $str .= sprintf(" %d次剩余次数", $this->lower);
                break;
            case Constant::EQUIP_TYPE_DRUP:
                $str .= sprintf(" %d点剩余补充量", $this->lower);
                break;
        }

        return $str;
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
