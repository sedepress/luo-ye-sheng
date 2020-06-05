<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'external_id',
        'nickname',
        'character_level',
        'mining_level',
        'forging_level',
        'fatigue_value',
        'lucky_value',
        'manpower',
        'current_exp',
        'history_exp',
        'current_gold',
        'invitation_code'
    ];
}
