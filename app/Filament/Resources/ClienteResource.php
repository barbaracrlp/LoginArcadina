<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel= 'Clientes';

    protected static ?string $navigationGroup = "Ventas";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //agregamos el formulario 
                Forms\Components\TextInput::make('usuario')
                ->label('Nombre')
                ->autofocus(),
                Forms\Components\TextInput::make('mail')
                ->label('Email'),
                Forms\Components\TextInput::make('telefono')
                ->tel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //agregamos las columnas de la tabla
                Tables\Columns\TextColumn::make('usuario')
                ->label('Nombre')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('mail')
                ->label('Email')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('telefono')
                ->label('Teléfono')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                //primer intento de crear accion de eliminar con texto custom
            Action::make('Eliminar')
            ->action(fn (Cliente $record) => $record->delete())
            ->requiresConfirmation()
            ->modalHeading('Eliminar Cliente')
            ->modalDescription('Seguro que quiere eliminar este cliente?')
            ->modalSubmitActionLabel('Sí, Eliminar Cliente')
            ->modalCancelActionLabel('Cancelar')
            ->color('danger')
            ->modalIcon('heroicon-o-trash'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()->label('Eliminar')
                ->requiresConfirmation(),
                // ]),
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
