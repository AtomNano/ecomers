<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'address',
        'province',
        'city',
        'district',
        'postal_code',
        'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'shipping_address_id');
    }

    /**
     * Get the full address as a single string
     */
    public function getFullAddressAttribute()
    {
        $parts = [
            $this->address,
            $this->district,
            $this->city,
            $this->province,
            $this->postal_code
        ];

        return implode(', ', array_filter($parts));
    }
}
