<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uninterested extends Model
{
    use HasFactory;
  protected $table = 'uninterested';

    protected $fillable = [
        'content_id',
        'type',
        'filter_by',
        'user_id'
    ];

    public $timestamps = false;
    public function truck_details()
    {
        return $this->belongsTo(TruckShop::class,'truck_managment_id','id');
    }
}
