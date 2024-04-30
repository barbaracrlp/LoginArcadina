<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlbumResource\Pages;
use App\Filament\Resources\AlbumResource\RelationManagers;
use App\Models\Album;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



class AlbumResource extends Resource
{
    protected static ?string $model = Album::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationLabel= 'Galerías';

    protected static ?string $navigationGroup = "Images";

    

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
                ->extraInputAttributes(['tabindex'=>1]),
                Forms\Components\TextInput::make('contenido'),
                Forms\Components\TextInput::make('tipo')
                ->label('Tipo')
                ->disabled(),
                DateTimePicker::make('f_modi')
                ->label('Última modificacion')
                ->disabled()
                ->format('Y-m-d H:i:s'),
                Forms\Components\Toggle::make('publicado')
                ->label('Publicado')
                ->onIcon('heroicon-s-eye')
                ->offIcon('heroicon-m-eye-slash')
                ->onColor('success')
                ->offColor('danger'),
                //la fecha com a tal es crea al fer el commit a la DB no al crear una galeria
                //es la fecha de creacion

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //las columnas 
                 //ahora la columna
                 Tables\Columns\TextColumn::make('titulo')
                 ->label('Título')
                 ->sortable()
                 ->searchable(),
            //  Tables\Columns\CheckboxColumn::make('publicado'),
             Tables\Columns\ToggleColumn::make('publicado')
             ->label('Publicado')
                // ->onIcon('heroicon-s-eye')
                ->offIcon('heroicon-m-eye-slash')
                ->onColor('success')
                ->offColor('danger'),
          
             Tables\Columns\TextColumn::make('tipo')
                 ->sortable()
                 ->searchable(),
                 Tables\Columns\TextColumn::make('estado')
                 ->sortable()
                 ->searchable(),

            ])
            ->filters([
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
            'index' => Pages\ListAlbums::route('/'),
            'create' => Pages\CreateAlbum::route('/create'),
            'edit' => Pages\EditAlbum::route('/{record}/edit'),
        ];
    }
}
