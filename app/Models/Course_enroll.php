<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_enroll extends Model
{
    use HasFactory;


    protected $table = 'course_enroll';

    protected $fillable =
    [
        'course_id',
        'user_id',
        'transaction_id',
        'enroll_date'
    ];

    public function transaction(){
        return $this->hasMany(Transaction::class, 'transaction_id', 'transaction_id');
    }

    public function course(){
        return $this->hasOne(Course::class, 'id', 'course_id');
    }

    
    

}