<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'pin'
    ];

    /**
     * Get the account that owns the Profile.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}