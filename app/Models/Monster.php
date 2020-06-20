<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monster extends Model
{
    public function battleScene()
    {
        return $this->belongsTo(BattleScene::class);
    }
}
