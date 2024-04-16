<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContenidoResource\Pages;
use App\Filament\Resources\ContenidoResource\RelationManagers;
use App\Models\Contenido;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContenidoResource extends Resource
{
    protected static ?string $model = Contenido::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Forms\Components\TextInput::make('tipo'),
                Forms\Components\TextInput::make('f_crea'),
                Forms\Components\TextInput::make('f_modi'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //ahora la columna
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\CheckboxColumn::make('publicado'),
                Tables\Columns\TextColumn::make('estado')
                    ->color(fn (string $state): string => match ($state) {
                        0 => 'gray',
                        2 => 'warning',
                        1 => 'success',
                        99 => 'danger',
                    }),
                Tables\Columns\TextColumn::make('tipo')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //tengo que hacer un filtro por tipo
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
            'index' => Pages\ListContenidos::route('/'),
            'create' => Pages\CreateContenido::route('/create'),
            'edit' => Pages\EditContenido::route('/{record}/edit'),
        ];
    }
}
