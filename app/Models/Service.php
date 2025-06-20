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
        'image_path',
        'number_of_profiles',
        'product_link',
    ];

    /**
     * Get the accounts for the Service.
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }
}