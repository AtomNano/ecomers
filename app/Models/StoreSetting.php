<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $table = 'store_settings';
    
    protected $fillable = [
        'store_name',
        'phone',
        'address',
        'province',
        'city',
        'district',
        'maps_url',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'qris_image',
    ];
}
