<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    public function network_currency()
    {
        // return $this->belongsTo(Activity::class, 'id', 'activity_id');
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    protected $casts = [
        'min_amount' => 'decimal:11',
        'max_amount' => 'decimal:11',
        'fee_digit' => 'decimal:11',
    ];
}
