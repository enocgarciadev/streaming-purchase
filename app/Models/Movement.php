<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'type',
        'amount',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2', // Asegura que la cantidad se maneje como decimal con 2 dígitos
        'type' => \App\MovementType::class, // Opcional pero recomendado: usa un Enum para el tipo
    ];

    /**
     * Get the account that owns the Movement.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}