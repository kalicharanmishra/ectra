<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodtruckShop extends Model
{
    use HasFactory;
    protected $table = 'food_truck_shop';
        protected $fillable = [
        'food_truck_id',
        'state',
        'city',
        'zip_code',
        'start_time',
        'end_time'

    ];
}
