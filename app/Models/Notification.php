<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public function video_details()
    {
        return $this->hasOne(Video::class, 'id', 'video_id');
    }
    public function user_details()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function other_user_details()
    {
        return $this->hasOne(User::class, 'id', 'other_id');
    }
}
