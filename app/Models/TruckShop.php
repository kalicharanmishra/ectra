<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckShop extends Model
{
    use HasFactory;
  protected $table = 'truck_shop';

    protected $fillable = [
        'truck_managment_id',
        'street',
        'state',
        'city',
        'zip_code',
        'start_time',
        'end_time'

    ];

    public function truck_details()
    {
        return $this->belongsTo(TruckShop::class,'truck_managment_id','id');
    }
}
