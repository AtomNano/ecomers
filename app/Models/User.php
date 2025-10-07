<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_OWNER = 'owner';
    const ROLE_CUSTOMER = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @resources\sass\_variables.scss array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'address',
        'phone_number',
        'province',
        'city',
        'district',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @resources\sass\_variables.scss array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}