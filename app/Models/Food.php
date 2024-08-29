<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\FoodImage;
use App\Models\FoodItem;
use App\Models\TruckShop;

class Food extends Model
{
    use HasFactory;


    protected $fillable = [
    'category_id', 
    'food_name', 
    'food_description',
    'base_price',
    'stock'
];

    public function food_multiple_images()
    {
        return $this->hasMany(FoodImage::class);
    }
    public function food_items()
    {
        return $this->hasMany(FoodItem::class);
    }


    public function category()
    {
        return $this->belongsTo(Categories::class,'category_id', 'id');
    }

    public function Truck_details()
    {
        return $this->belongsTo(TruckShop::class,'truck_managment_id', 'id');
    }
}
