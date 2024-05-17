<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetodoPaoResource\Pages;
use App\Filament\Resources\MetodoPaoResource\RelationManagers;
use App\Models\MedioPago;
use App\Models\MetodoPao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MetodoPaoResource extends Resource
{
    protected static ?string $model = MedioPago::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                 //agrego primero el formulario 
                 Forms\Components\TextInput::make('titulo')
                 ->required()
                 ->label('Título')
                 ->maxLength(255)
                 ->autofocus()
                 ->extraInputAttributes(['tabindex' => 1]),
             //la fecha com a tal es crea al fer el commit a la DB no al crear una galeria
             //es la fecha de creacion
             Forms\Components\TextInput::make('contenido'),
             Forms\Components\TextInput::make('tipo')
             ->label('Tipo')
             ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMetodoPaos::route('/'),
            'create' => Pages\CreateMetodoPao::route('/create'),
            'edit' => Pages\EditMetodoPao::route('/{record}/edit'),
        ];
    }
}
