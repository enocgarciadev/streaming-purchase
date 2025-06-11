<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $modelLabel = 'Cliente';
    protected static ?string $pluralModelLabel = 'Clientes';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Gestión de Cuentas';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre del Cliente')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email() // Valida que sea un formato de email válido
                    ->unique(ignoreRecord: true) // Asegura que el email sea único, ignorando el propio registro al editar
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel() // Valida que sea un formato de teléfono (aunque no es estricto como email)
                    ->nullable()
                    ->maxLength(20), // Un límite razonable para teléfonos
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at') // Opcional: para ver cuándo se creó
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Oculto por defecto, se puede mostrar
            ])
            ->filters([
                // Puedes añadir filtros aquí más adelante
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
