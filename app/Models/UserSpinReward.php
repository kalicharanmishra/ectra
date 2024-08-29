<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSpinReward extends Model
{
    use HasFactory;

    public function spin_reward()
    {
        return $this->hasOne(SpinReward::class, 'id', 'spin_reward_id');
    }

    
}
