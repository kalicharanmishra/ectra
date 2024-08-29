<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circullum extends Model
{
    use HasFactory;


    protected $table = 'circullum';

    protected $fillable =
    [
        'course_id',
        'title'
    ];
    public $timestamps = false;
    public function circullum_topic()
    {
        return $this->hasMany(Circullum_topic::class,'circullum_id','id');
    }
}