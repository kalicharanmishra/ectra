<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\FoodtruckImage;
use App\Models\FoodtruckShop;
use App\Models\TruckShop;


class FoodTruck extends Model
{
    use HasFactory;
    protected $table = 'food_trucks';
    
    public function Foodtruck_multiple_images()
    {
        return $this->hasMany(FoodtruckImage::class);
    }
    public function Foodtruck_shops()
    {
        return $this->hasMany(FoodtruckShop::class);
    }


    public function vendor_details()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
