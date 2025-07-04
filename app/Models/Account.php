<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'email',
        'password',
        'secondary_password',
        'billing_date',
    ];

    // ¡IMPORTANTE! Eliminamos 'password' y 'secondary_password' del array de casts.
    protected function casts(): array
    {
        return [
            'billing_date' => 'date',
        ];
    }

    /**
     * Get the service that owns the Account.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the profiles for the Account.
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
}