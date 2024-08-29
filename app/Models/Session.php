<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;


    protected $table = 'session';

    protected $fillable =
    [
        'user_id',
        'course_id',
        'class_url',
        'active_date',
        'active_time',
        'class_end_time'
    ];
    public $timestamps = false;
   
}