<?php

namespace App\Filament\Resources\MovementResource\Pages;

use App\Filament\Resources\MovementResource;
use Filament\Resources\Pages\CreateRecord;
use Carbon\Carbon; // Importa Carbon para manejar fechas
use App\MovementType; // <-- ¡IMPORTA EL ENUM AQUÍ!

class CreateMovement extends CreateRecord
{
    protected static string $resource = MovementResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $movement = parent::handleRecordCreation($data); // Crea el movimiento

        // Compara directamente con la instancia del Enum
        if ($movement->type === MovementType::Income) { // <-- ¡CAMBIO AQUÍ!
            $account = $movement->account;

            if ($account) {
                // Asegúrate de que $account->billing_date sea un objeto Carbon si no lo es por cast
                // Aunque con 'date' cast en Account model ya debería serlo.
                $account->billing_date = Carbon::parse($account->billing_date)->addMonth();
                $account->save();
            }
        }

        return $movement;
    }
}