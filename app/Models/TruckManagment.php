<?php

namespace App\Models;

use App\Models\User;
use App\Models\TruckImage;
use App\Models\TruckShop;
use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckManagment extends Model
{
    use HasFactory;
    protected $table = 'truck_managment';

    public function truck_multiple_images()
    {
        return $this->hasMany(TruckImage::class);
    }
    public function truck_shops()
    {
        return $this->hasMany(TruckShop::class);
    }


    public function vendor_details()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }


    // public function vendor_details()
    // {
    //     return $this->hasOne(User::class);
    // }

}
