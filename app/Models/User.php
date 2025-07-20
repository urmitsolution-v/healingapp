<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens , HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'village',
        'city',
        'profile_photo',
        'state',
        'user_type',
        'is_block',
        'otp',
        'otp_expires_at',
        'role_id',
        'address',
        'order_villages',
        'stock_villages',
        'dob',
        'declearation',
        'status',
        'user_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 
     * 
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
     
     public function villageview()
{
    return $this->belongsTo(Locations::class, 'village', 'id');
}

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

public function role_new()
{
    return $this->belongsTo(Role::class, 'role_id');
}


public function hasPermission(string $permission): bool
{
    // Role या permissions नहीं हैं तो false return करें
    if (!$this->role_new || empty($this->role_new->permissions)) {
        return false;
    }

    // permissions json से decode करें अगर string हो
    $permissions = $this->role_new->permissions;
    if (is_string($permissions)) {
        $permissions = json_decode($permissions, true);
    }

    if (!is_array($permissions)) {
        return false;
    }

    // permission को "menu.action" में split करें
    $parts = explode('.', $permission);
    if (count($parts) !== 2) {
        return false;
    }

    [$menu, $action] = $parts;

    // check करें कि permissions में वो menu और action है या नहीं और value "1" है
    return isset($permissions[$menu][$action]) && $permissions[$menu][$action] === "1";
}


}