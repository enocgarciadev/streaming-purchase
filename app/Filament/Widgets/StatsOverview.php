<?php

namespace App\Filament\Widgets;

use App\Models\Account; // Importa tu modelo Account
use App\Models\Client;  // Importa tu modelo Client
use App\Models\Service; // Importa tu modelo Service
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat; // Importa la clase Stat

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0; // Opcional: Ordena este widget para que aparezca primero

    protected function getStats(): array
    {
        // Obtener el total de clientes
        $totalClients = Client::count();

        // Obtener el total de servicios
        $totalServices = Service::count();

        // Obtener el total de cuentas
        $totalAccounts = Account::count();

        // Obtener cuentas con perfiles llenos
        // Esto requiere cargar la relación 'service' y 'profiles'
        $accountsWithFullProfiles = Account::query()
            ->with(['service', 'profiles']) // Carga las relaciones necesarias
            ->get() // Obtiene todas las cuentas
            ->filter(function (Account $account) {
                $maxProfiles = $account->service->number_of_profiles ?? 0;
                $currentProfiles = $account->profiles->count();
                // Considera "lleno" si el número actual de perfiles es igual o mayor al máximo permitido (y el máximo es > 0)
                return $maxProfiles > 0 && $currentProfiles >= $maxProfiles;
            })
            ->count();

        return [
            Stat::make('Total de Clientes', $totalClients)
                ->description('Clientes registrados')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'), // Puedes elegir colores como 'primary', 'success', 'warning', 'danger', 'info'

            Stat::make('Total de Servicios', $totalServices)
                ->description('Servicios ofrecidos')
                ->descriptionIcon('heroicon-o-queue-list')
                ->color('primary'),

            Stat::make('Total de Cuentas', $totalAccounts)
                ->description('Cuentas activas')
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('success'),

            Stat::make('Cuentas Llenas', $accountsWithFullProfiles)
                ->description('Cuentas con perfiles al máximo')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('danger'), // Color rojo para indicar alerta
        ];
    }
}