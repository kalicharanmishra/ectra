<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{
    use HasFactory;


function sound_used(){
    return $this->hasMany(video::class,'sound','sound');
}
   
}
