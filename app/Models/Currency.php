<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = ['code','symbol','image','network_name','min_amount','max_amount','fee_digit'];

    public function networks()
    {
        return $this->hasMany(Network::class, 'currency_id', 'id');
    }
}
