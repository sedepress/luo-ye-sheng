<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function getShopDescAttribute()
    {
        $arr = [1, 2, 3];
        $str = '价格' . $this->price;
        if ($this->price_type == 1) {
            $str .= '人力值';
        } else {
            $str .= '金币';
        }

        if (in_array($this->type, $arr)) {
            switch ($this->type) {
                case 1:
                    $str .= sprintf(" 攻击范围%d ~ %d", $this->lower, $this->upper);
                    break;
                case 2:
                    $str .= sprintf(" %d点护甲", $this->lower);
                    break;
                case 3:
                    $str .= sprintf(" %d点速度", $this->lower);
                    break;
            }
        }

        return $str;
    }
}
