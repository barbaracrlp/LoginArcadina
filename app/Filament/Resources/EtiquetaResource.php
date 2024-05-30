<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EtiquetaResource\Pages;

use App\Models\Etiqueta;
use Filament\Forms;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class EtiquetaResource extends Resource
{
    protected static ?string $model = Etiqueta::class;

    protected static ?string $navigationIcon = 'fas-tag';
    protected static ?string $navigationGroup = "Tienda";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('pedidos_count')->counts('pedidos')->label('Pedidos'),
                TextColumn::make('clientes_count')->counts('clientes')->label('Clientes'),
                TextColumn::make('albums_count')->counts('albums')->label('Galerías'),
                TextColumn::make('titulo'),
           
            ])
            ->filters([
                //
            ])
            ->actions([
             
            ])
            ->bulkActions([
           
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
            'index' => Pages\ListEtiquetas::route('/'),
            // 'create' => Pages\CreateEtiqueta::route('/create'),
            // 'edit' => Pages\EditEtiqueta::route('/{record}/edit'),
        ];
    }
}
