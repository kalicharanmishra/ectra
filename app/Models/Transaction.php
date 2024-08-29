<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Transaction extends Model

{

    use HasFactory;





    protected $table = 'transaction';



    protected $fillable =

    [

        'course_id',

        'teacher_id',

        'subscriber_id',

        'transaction_id','payment_request_id',

        'status',

        'price',

        'teacher_commission',

        'admin_commission'

    ];

    public $timestamps = false;

    

    public function enroll(){

        return $this->hasOne(Course_enroll::class, 'transaction_id', 'transaction_id');

    }



    public function course(){

        return $this->hasOne(Course::class, 'id', 'course_id')->with('getCatAttribute');

    }

    public function teacher()

    {

        return $this->hasOne(User::class,'id','teacher_id');

    }

    public function Circullum_topic()

    {

        return $this->hasMany(Circullum_topic::class,'course_id','course_id');

    }

    public function teacher_profile()

    {

        return $this->hasOne(Teacher_profile::class,'user_id','teacher_id');

    }

    public function usered()

    {

        return $this->hasOne(User::class,'id','subscriber_id');

    }

}