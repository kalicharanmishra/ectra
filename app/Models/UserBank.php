<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class UserBank extends Model
{

    use HasFactory;
    protected $table='user_banks';
    protected $fillable=[
        'user_id',
        'bank_name',
        'bank_account',
        'bank_account_holder',
        'bank_address',
        'bank_ifsc'
    ];

}
