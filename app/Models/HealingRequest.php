<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealingRequest extends Model
{

     protected $table = 'healing_requests';
     
     protected $fillable = [
        'user_id',
        'healing_requirement',
        'date',
        'time',
        'status',
        'completed_remarks',
        'is_completed_by_healer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
{
    return $this->hasMany(HealingBid::class);
}
}