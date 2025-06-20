<?php

namespace App;

use Filament\Support\Contracts\HasLabel;
enum MovementType: string implements HasLabel
{
    case Income = 'income';
    case Expense = 'expense';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Income => 'Entrada',
            self::Expense => 'Salida',
        };
    }
}