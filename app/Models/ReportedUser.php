<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedUser extends Model
{
    use HasFactory;

    public function user_detail()
    {
        return $this->hasOne(User::class, 'id', 'reported_user');
    }

    public function reporter_detail()
    {
        return $this->hasOne(User::class, 'id', 'reported_by');
    }

    public function warning()
    {
        return $this->hasOne(UserWarning::class, 'user_id', 'reported_user');
    }
}
