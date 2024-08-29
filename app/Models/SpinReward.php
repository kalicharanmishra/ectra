<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpinReward extends Model
{
    use HasFactory;

    public function user_spin_reward()
    {
        return $this->hasOne(UserSpinReward::class, 'spin_reward_id', 'id');
    }
}
