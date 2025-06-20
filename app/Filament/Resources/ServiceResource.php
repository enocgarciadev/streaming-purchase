<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput; 
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationLabel = 'Servicios'; 
    protected static ?string $modelLabel = 'Servicio'; 
    protected static ?string $pluralModelLabel = 'Servicios';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Gestión de Productos';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre del Servicio')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('image_path') // <-- ¡Añade este campo!
                    ->label('Imagen del Servicio')
                    ->image() // Valida que sea una imagen
                    ->directory('service-images') // Directorio donde se guardarán las imágenes en storage/app/public/
                    ->nullable() // Puede ser nulo si la imagen no es obligatoria
                    ->visibility('public'), // Asegura que las imágenes sean accesibles públicamente

                TextInput::make('number_of_profiles')
                    ->label('Número de Perfiles')
                    ->numeric()
                    ->nullable(),

                TextInput::make('product_link')
                    ->label('Link del Producto')
                    ->url()
                    ->nullable(),
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

                ImageColumn::make('image_path') // <-- ¡Añade esta columna!
                    ->label('Imagen')
                    ->height(40) // Opcional: ajusta la altura de la imagen en la tabla
                    ->width(40), // Opcional: ajusta el ancho

                TextColumn::make('number_of_profiles')
                    ->label('Perfiles')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('product_link')
                    ->label('Link')
                    ->url(fn (Service $record): ?string => $record->product_link)
                    ->openUrlInNewTab(),
            ])
            ->filters([
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
