<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovementResource\Pages;
use App\Filament\Resources\MovementResource\RelationManagers;
use App\Models\Movement;
use App\Models\Account; // Importa el modelo Account
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\TextColumn;

// Si usaste el Enum
use App\MovementType;


class MovementResource extends Resource
{
    protected static ?string $model = Movement::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar'; // Icono para movimientos
    protected static ?string $navigationGroup = 'Gestión Financiera'; // Nuevo grupo
    protected static ?string $navigationLabel = 'Movimientos';
    protected static ?string $modelLabel = 'Movimiento';
    protected static ?string $pluralModelLabel = 'Movimientos';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('account_id')
                    ->label('Cuenta')
                    ->options(Account::all()->pluck('email', 'id')) // Muestra emails de cuentas
                    ->required()
                    ->searchable()
                    ->preload(),

                ToggleButtons::make('type') // Botones para seleccionar 'income' o 'expense'
                    ->label('Tipo de Movimiento')
                    ->inline() // Botones en una sola línea
                    ->options(MovementType::class) // Usa el Enum si lo creaste
                    // ->options([ // Si no usas Enum
                    //     'income' => 'Entrada',
                    //     'expense' => 'Salida',
                    // ])
                    ->colors([
                        'income' => 'success',
                        'expense' => 'danger',
                    ])
                    ->icons([
                        'income' => 'heroicon-o-arrow-trending-up',
                        'expense' => 'heroicon-o-arrow-trending-down',
                    ])
                    ->required(),

                TextInput::make('amount')
                    ->label('Cantidad')
                    ->numeric()
                    ->required()
                    ->inputMode('decimal') // Para teclados de números con decimal
                    ->prefix('C$') // Prefijo de moneda, ajusta según tu necesidad
                    ->minValue(0.01), // No permite cantidades negativas o cero

                Textarea::make('description')
                    ->label('Descripción')
                    ->nullable()
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('account.email')
                    ->label('Cuenta')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Tipo')
                    // Si usas el Enum, getLabel() se encarga de esto
                    ->formatStateUsing(fn (MovementType $state): string => $state->getLabel())
                    ->badge() // Muestra como un "badge"
                    ->color(fn (MovementType $state): string => match ($state) {
                        MovementType::Income => 'success',
                        MovementType::Expense => 'danger',
                    }),

                TextColumn::make('amount')
                    ->label('Cantidad')
                    ->numeric(decimalPlaces: 2) // Muestra con 2 decimales
                    ->prefix('C$')
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Descripción')
                    ->words(10) // Limita a 10 palabras en la tabla
                    ->tooltip(fn (string $state): string => $state) // Muestra la descripción completa al pasar el mouse
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Fecha Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('account_id')
                    ->label('Por Cuenta')
                    ->options(Account::all()->pluck('email', 'id'))
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Por Tipo')
                    ->options(
                        collect(MovementType::cases())
                            ->mapWithKeys(fn (MovementType $type) => [$type->value => $type->getLabel()])
                            ->toArray()
                    ),
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
            // No hay RelationManagers aquí por ahora
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovements::route('/'),
            'create' => Pages\CreateMovement::route('/create'),
            'edit' => Pages\EditMovement::route('/{record}/edit'),
        ];
    }
}