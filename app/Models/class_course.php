<?php declare(strict_types=1);

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class class_course extends Model

{

    use HasFactory;

protected $table = "class_course";

    protected $fillable = [

        'course_name',

        'time',

        'url',

        'start_date',

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

        return $this->hasOne(User::class, 'id')->with('teacher_profile')->withCount('class_course')->withCount('teacher_sessions');

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

