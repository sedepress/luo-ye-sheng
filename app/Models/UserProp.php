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
        'rating',
        'type',
        'shop_id',
        'is_equip',
        'remaining_usage',
        'status',
    ];

    public function getPropDescAttribute()
    {
        $arr = [1, 2, 3];
        $str = '';

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

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
