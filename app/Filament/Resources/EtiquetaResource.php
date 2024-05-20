<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EtiquetaResource\Pages;
use App\Filament\Resources\EtiquetaResource\RelationManagers;
use App\Models\Etiqueta;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EtiquetaResource extends Resource
{
    protected static ?string $model = Etiqueta::class;

    protected static ?string $navigationIcon = 'fas-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('titulo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('pedidos_count')->counts('pedidos'),
                TextColumn::make('clientes_count')->counts('clientes'),
                TextColumn::make('albums_count')->counts('albums'),
                TextColumn::make('titulo'),
           
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
            'index' => Pages\ListEtiquetas::route('/'),
            'create' => Pages\CreateEtiqueta::route('/create'),
            'edit' => Pages\EditEtiqueta::route('/{record}/edit'),
        ];
    }
}
