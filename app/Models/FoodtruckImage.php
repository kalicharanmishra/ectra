<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodtruckImage extends Model
{
    use HasFactory;
    protected $table = 'food_truck_images';

    protected $fillable = [
        'food_truck_id',
        'food_truck_image',
        'extension'

    ];
}
