<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Models\Account;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\ImageColumn;


class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Gestión de Cuentas';
    protected static ?string $modelLabel = 'Cuenta de Servicio';
    protected static ?string $pluralModelLabel = 'Cuentas de Servicio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalles de la Cuenta')
                    ->schema([
                        Forms\Components\Select::make('service_id')
                            ->label('Servicio Asociado')
                            ->relationship('service', 'name')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('email')
                            ->label('Correo de la Cuenta')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        // CAMBIO: No usar password() para que sea visible en el formulario y no se deshidrate
                        Forms\Components\TextInput::make('password')
                            ->label('Contraseña Principal de la Cuenta')
                            ->required() // Sigue siendo requerido al crear
                            ->maxLength(255),
                        // CAMBIO: No usar password() para que sea visible en el formulario y no se deshidrate
                        Forms\Components\TextInput::make('secondary_password')
                            ->label('Contraseña del Perfil/Secundaria')
                            ->nullable() // Puede ser nulo
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('billing_date')
                            ->label('Fecha de Facturación')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('service.image_path') // <-- ¡Aquí la relación anidada!
                    ->label('Imagen Servicio')
                    ->square(),
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Servicio')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->sortable(),
                // CAMBIO: Mostrar la contraseña principal en la tabla
                Tables\Columns\TextColumn::make('password')
                    ->label('Contraseña Principal')
                    ->searchable() // Puedes buscarla si quieres
                    ->toggleable(isToggledHiddenByDefault: false), // Visible por defecto

                // CAMBIO: Mostrar la contraseña secundaria en la tabla
                Tables\Columns\TextColumn::make('secondary_password')
                    ->label('Contraseña Secundaria')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false), // Visible por defecto

                Tables\Columns\TextColumn::make('billing_date')
                    ->label('Fecha de Facturación')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Servicio')
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
            \App\Filament\Resources\AccountResource\RelationManagers\ProfilesRelationManager::class,
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