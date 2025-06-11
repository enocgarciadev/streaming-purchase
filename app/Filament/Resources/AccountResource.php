<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
use App\Models\Service; // Importa el modelo Service
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select; // Para el campo de selección del servicio
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker; // Para la fecha de facturación
use Filament\Tables\Columns\TextColumn;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card'; 
    protected static ?string $navigationGroup = 'Gestión de Cuentas';
    protected static ?string $navigationLabel = 'Cuentas';
    protected static ?string $modelLabel = 'Cuenta';
    protected static ?string $pluralModelLabel = 'Cuentas';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('service_id')
                    ->label('Servicio')
                    ->options(Service::all()->pluck('name', 'id')) // Carga los servicios desde la DB
                    ->required()
                    ->searchable()
                    ->preload(), // Precarga opciones si hay muchas

                TextInput::make('email')
                    ->label('Correo de la Cuenta')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),

                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => bcrypt($state)) // Hashea la contraseña al guardar
                    ->dehydrated(fn (?string $state): bool => filled($state)) // Solo guarda si el campo no está vacío
                    ->required(fn (string $operation): bool => $operation === 'create') // Requerido solo al crear
                    ->currentPassword(false), // Importante si tienes reglas de confirmación de password de Laravel

                DatePicker::make('billing_date')
                    ->label('Fecha de Facturación')
                    ->required()
                    ->native(false) // Para usar el selector de fecha más moderno
                    ->weekStartsOnSunday(false), // O true, dependiendo de tu convención
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service.name') // Muestra el nombre del servicio relacionado
                    ->label('Servicio')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('billing_date')
                    ->label('Facturación')
                    ->date()
                    ->sortable(),

                TextColumn::make('profiles_count') // Para mostrar el conteo de perfiles actuales
                    ->counts('profiles') // Cuenta la relación 'profiles'
                    ->label('Perfiles (Actual/Máx)')
                    ->getStateUsing(function (Account $record): string {
                        $maxProfiles = $record->service->number_of_profiles ?? 0;
                        $currentProfiles = $record->profiles->count();
                        return "$currentProfiles / $maxProfiles";
                    })
                    ->color(function (Account $record): string {
                        $maxProfiles = $record->service->number_of_profiles ?? 0;
                        $currentProfiles = $record->profiles->count();
                        if ($maxProfiles > 0 && $currentProfiles >= $maxProfiles) {
                            return 'danger'; // Si está lleno
                        }
                        if ($maxProfiles > 0 && $currentProfiles > $maxProfiles * 0.8) {
                            return 'warning'; // Si está casi lleno
                        }
                        return 'success'; // Si hay espacio
                    }),
            ])
            ->filters([
                // Filtro por servicio
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Por Servicio')
                    ->options(Service::all()->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProfilesRelationManager::class, // <-- ¡Importante!
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}