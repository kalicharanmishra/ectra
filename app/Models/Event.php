<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TruckShop;
use App\Models\TruckManagment;
use App\Models\TruckImage;


class Event extends Model
{

     use HasFactory;
    protected $table='events';
    protected $fillable=[
        'vendor_id',
        'user_id',
        'street_name',
        'city',
        'state',
        'zipcode',
        'date',
        'time',
        'phone',
        'email',
        'duration',
        'status'
    ];

    public function vendor_details()
    {
        return $this->belongsTo(User::class,'vendor_id', 'id');
    }

    public function Customer_details()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function truck_details()
    {
        return $this->hasMany(TruckShop::class,'truck_managment_id','id');
    }

    public function truck_detail()
    {
        return $this->belongsTo(TruckManagment::class,'vendor_id','id');
    }

    public function truck_images(){
        return $this->hasMany(TruckImage::class,'truck_managment_id','id');
    }
    
}
