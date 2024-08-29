<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TruckShop;
use App\Models\Food;
use App\Models\FoodImage;
use App\Models\OrderItem;


class Order extends Model
{

     use HasFactory;
    protected $table='orders';
    protected $fillable=[
        'vendor_id',
        'user_id',
        'promo_code',
        'promo_code_discount',
        'price',
        'fee',
        'total_amount',
        'info',
        'payment_type',
        'payment_id',
        'status'
    ];

    public function vendor_details()
    {
        return $this->belongsTo(User::class,'vendor_id', 'id');
    }

    public function customer_details()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    // public function food()
    // {
    //     return $this->belongsTo(Food::class,'food_id', 'id');
    // }

    // public function food_images()
    // {
    //     return $this->hasMany(FoodImage::class,'food_id','food_id');
    // }
    public function order_items()
    {
        return $this->hasMany(OrderItem::class,'order_id','id');
    }
    public function food() {
        return $this->belongsTo(Food::class);
    }
}
