<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Traits\HasHashedMediaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'dob',
        'password',
        'phone',
        'avtars',
        'gender',
        'status',
        'short_bio',
        'bio','location',
        'cover_image',
        'notification',
        'two_FA_toggle',
        'social_login_id',
        'social_login_type',
        'firebase_token',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

  

    public function user_activity_counters()
    {
        return $this->hasOne(UserActivityCounter::class, 'user_id', 'id');
    }
    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id', 'id')->withCount('course_enroll_student');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'teacher_id', 'id');
    }
    public function coursesenroll()
    {
        return $this->hasMany(Course_enroll::class, 'user_id', 'id');
    }
    public function teacher_sessions()
    {
        return $this->hasMany(Session::class, 'user_id', 'id');
    }
    public function teacher_profile()
    {
        return $this->hasOne(Teacher_profile::class, 'user_id', 'id');
    }


}
