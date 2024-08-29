<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseHashTags extends Model
{
    use HasFactory;
    protected $table = "course_hashtags";

    public function course(){
        return $this->hasOne(Course::class, 'id', 'course_id');
    }
}