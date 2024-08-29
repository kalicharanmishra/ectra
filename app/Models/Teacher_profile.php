<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Teacher_profile extends Model

{

    use HasFactory;





    protected $table = 'teacher_profile';



    protected $fillable =

    [

        'user_id',

        'profile_name',

        'experence',

        'tag',
        'since',

        'passing_out',

        'degree_obtained',

        'degree_from',

        'country',

        'city',

        'intro_video',

        'intro_text','admin_commission'

    ];

    public $timestamps = false;

}