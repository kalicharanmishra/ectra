<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Attendence extends Model
{

    use HasFactory;

    protected $table = 'attendence';

    protected $fillable = ['course_id','class_id','teacher_id','attendence','user_id'];



    public function course()
    {
        return $this->hasOne(Course::class,'id','course_id');
    }

    public function class()
    {

        return $this->hasOne(class_course::class,'id','class_id');

    }



    public function classtopic()
    {

        return $this->hasMany(class_course::class,'class_id','class_id');

    }



    public function teacher()
    {

        return $this->hasOne(User::class,'id','teacher_id');

    }

    public function usered()
    {

        return $this->hasOne(User::class,'id','user_id');

    }


}