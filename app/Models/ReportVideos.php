<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportVideos extends Model
{
    use HasFactory;

    public function video_detail()
    {
        return $this->hasOne(Video::class, 'id', 'video_id');
    }

    public function reporter_detail()
    {
        return $this->hasOne(User::class, 'id', 'reported_by');
    }
}
