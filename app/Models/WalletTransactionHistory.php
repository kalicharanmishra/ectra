<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransactionHistory extends Model
{
    use HasFactory;
    protected $table = "wallet_transaction_history";
}