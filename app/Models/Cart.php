<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TruckShop;
use App\Models\Food;
use App\Models\FoodImage;


class Cart extends Model
{

     use HasFactory;
    protected $table='carts';
    protected $fillable=[
        'vendor_id',
        'user_id',
        'food_id',
        'food_items',
        'quantity',
        'order_id'
    ];

    // public function vendor_details()
    // {
    //     return $this->belongsTo(User::class,'vendor_id', 'id');
    // }

    public function food()
    {
        return $this->belongsTo(Food::class,'food_id', 'id');
    }

    public function food_images()
    {
        return $this->hasMany(FoodImage::class,'food_id','food_id');
    }
}
