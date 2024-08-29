<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'comment_by',
        'comment',
        'rate',
        'name',
    ];

    public function comment_likes()
    {
        return $this->hasMany(CommentLike::class, 'comment_id', 'id');
    }

    public function use_name()
    {
        return $this->hasMany(user::class, 'id', 'comment_by');
    }
}
