<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'video',
        'filter',
        'skill_level',
        'category',
        'hashtags',
        'visibility',
        'is_comment_allowed',
        'is_enabled',
        'description',
        'short_desc',
        'price_type',
        'price',
        'start_date',
        'total_class',
        'image',
        'video_thumbnail',
        'retting',
        'is_certification',
        'slug',
        'is_commentable',
        'class_held_on',
        'duration',
        'timing'
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category', 'id');
    }
    public function categorydata()
    {
        return $this->belongsTo(Categories::class, 'category', 'id');
    }
    
    public function getCatAttribute(){
        return $this->category();
    }
    public function course_owner()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->with('teacher_profile')->withCount('courses')->withCount('teacher_sessions');
    }
    public function course_circullum()
    {
        return $this->hasMany(Circullum::class, 'course_id', 'id');
    }
    public function circullum_topic()
    {
        return $this->hasMany(Circullum_topic::class, 'course_id', 'id');
    }
    public function course_enroll_student()
    {
        return $this->hasMany(Course_enroll::class, 'course_id', 'id');
    }
    public function course_comments()
    {
        return $this->hasMany(CourseComment::class, 'id', 'course_id');
    }

    public function courseHashTags()
    {
        return $this->hasMany(CourseHashTags::class, 'course_id', 'id');
    }
    public function cat_data(){
        return $this->hasOne(Categories::class, 'id','category');
    }
}
