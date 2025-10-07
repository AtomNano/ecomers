<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tierPrices()
    {
        return $this->hasMany(ProductTierPrice::class);
    }
}
