<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyWallet extends Model
{
    use HasFactory;

       protected $table = 'monthly_wallets';
   protected $fillable = [
        'user_id', 'month', 'year', 'credit', 'debit', 'balance'
    ];
    
}