<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BattleScene extends Model
{
    public function monster()
    {
        return $this->hasOne(Monster::class);
    }
}
