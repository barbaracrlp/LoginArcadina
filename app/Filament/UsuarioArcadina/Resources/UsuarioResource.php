<?php

namespace App\Filament\UsuarioArcadina\Resources;

use App\Filament\UsuarioArcadina\Resources\UsuarioResource\Pages;
use App\Filament\UsuarioArcadina\Resources\UsuarioResource\RelationManagers;
use App\Models\Usuario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsuarioResource extends Resource
{
    protected static ?string $model = Usuario::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //  //agrego el formulario dependiendo de la BD
                Forms\Components\TextInput::make('mail')
                    ->required()
                    ->email()
                    ->maxLength(255)
                    ->extraInputAttributes(['tabindex' => 1]),
                Forms\Components\TextInput::make('pass')
                    ->required()
                    ->extraInputAttributes(['tabindex' => 2])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //ahora se agregan las columnas de la tabla 
                Tables\Columns\TextColumn::make('mail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('usuario')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('nivel')
                    ->searchable(),
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
            'index' => Pages\ListUsuarios::route('/'),
            'create' => Pages\CreateUsuario::route('/create'),
            'edit' => Pages\EditUsuario::route('/{record}/edit'),
        ];
    }
}
