<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealingBid extends Model
{

    protected $table = 'healing_bids';
       
    protected $fillable = [
        'healing_request_id',
        'healer_id',
        'remarks',
        'assigned_healer_id',
    ];

    // Relations
    public function request()
    {
        return $this->belongsTo(HealingRequest::class, 'healing_request_id');
    }

    public function healer()
    {
        return $this->belongsTo(User::class, 'healer_id');
    }
}