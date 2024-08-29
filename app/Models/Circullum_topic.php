<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circullum_topic extends Model
{
    use HasFactory;


    protected $table = 'circullum_topic';

    protected $fillable =
    [
        'course_id',
        'circullum_id',
        'topic',
        'class_url',
        'description',
        'is_complete',
        'cover_time'
    ];
    public $timestamps = false;
}