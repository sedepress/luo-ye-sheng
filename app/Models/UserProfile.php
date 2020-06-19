<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'hero_id',
        'character_level',
        'mining_level',
        'forging_level',
        'invitation_code',
        'inv_num',
        'invite_people',
        'is_used_inv'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
