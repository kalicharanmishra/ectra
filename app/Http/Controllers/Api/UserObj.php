<?php

namespace App\Http\Controllers\Api;

class UserObj
{
    public $id;
    public $name;
    public $username;
    public $email;
    public $dob;
    public $phone;
    public $avatar;
    public $social_login_id;
    public $social_login_type;
    public $first_name;
    public $last_name;
    public $gender;
    public $website_url;
    public $bio;
    public $youtube;
    public $facebook;
    public $instagram;
    public $twitter;
    public $firebase_token;
    public $referral_count;
    public $following;
    public $followers;
    public $likes;
    public $levels;
    public $total_videos;
    public $box_two;
    public $box_three;

    public function __construct($values_arr)
    {
        $this->id = $values_arr['id'];
        $this->name = $values_arr['name'];
        $this->username = $values_arr['username'];
        $this->email = $values_arr['email'];
        $this->dob = $values_arr['dob'];
        $this->phone = $values_arr['phone'];
        $this->avatar = $values_arr['avatar'];
        $this->social_login_id = $values_arr['social_login_id'];
        $this->social_login_type = $values_arr['social_login_type'];
        $this->first_name = $values_arr['first_name'];
        $this->last_name = $values_arr['last_name'];
        $this->gender = $values_arr['gender'];
        $this->website_url = $values_arr['website_url'];
        $this->bio = $values_arr['bio'];
        $this->youtube = $values_arr['youtube'];
        $this->facebook = $values_arr['facebook'];
        $this->instagram = $values_arr['instagram'];
        $this->twitter = $values_arr['twitter'];
        $this->firebase_token = $values_arr['firebase_token'];
        $this->referral_count = $values_arr['referral_count'];
        $this->following = $values_arr['following'];
        $this->followers = $values_arr['followers'];
        $this->likes = $values_arr['likes'];
        $this->levels = $values_arr['levels'];
        $this->total_videos = $values_arr['total_videos'];
        $this->box_two = $values_arr['box_two'];
        $this->box_three = $values_arr['box_three'];
    }
}