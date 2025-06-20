<?php

namespace App\Filament\Resources\AccountResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput; // Importa TextInput
use Filament\Tables\Columns\TextColumn; // Importa TextColumn
use App\Models\Account; // Importa el modelo Account
use App\Models\Service; // Importa el modelo Service

class ProfilesRelationManager extends RelationManager
{
    protected static string $relationship = 'profiles';

    // Opcional: Personaliza las etiquetas del RelationManager
    protected static ?string $title = 'Perfiles Asociados';
    protected static ?string $navigationLabel = 'Perfiles';
    protected static ?string $modelLabel = 'Perfil';
    protected static ?string $pluralModelLabel = 'Perfiles';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre del Perfil')
                    ->required()
                    ->maxLength(255),
                TextInput::make('pin')
                    ->label('PIN del Perfil (4 dígitos)')
                    ->numeric()
                    ->minLength(4)
                    ->maxLength(4)
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre del Perfil')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pin')
                    ->label('PIN del Perfil')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Crear Perfil')
                    ->visible(function (RelationManager $livewire): bool {
                        // Lógica para limitar la creación de perfiles
                        $account = $livewire->ownerRecord; // Obtiene la instancia de la Account actual
                        $maxProfiles = $account->service->number_of_profiles ?? 0;
                        $currentProfiles = $account->profiles->count();

                        return $currentProfiles < $maxProfiles; // Solo visible si hay espacio
                    })
                    ->badge(function (RelationManager $livewire): string {
                        $account = $livewire->ownerRecord;
                        $maxProfiles = $account->service->number_of_profiles ?? 0;
                        $currentProfiles = $account->profiles->count();
                        return "($currentProfiles / $maxProfiles)"; // Muestra el conteo en el badge
                    }),
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
}