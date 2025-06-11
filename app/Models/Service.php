<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number_of_profiles',
        'product_link',
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }
}