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

use Filament\Tables\Enums\ActionsPosition;

use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Clientes';

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
                    ->label('Usuario')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail')
                    ->label('Email')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\CheckboxColumn::make('multiple')
                ->disabled()
               //funciona haciendo una funcion en el modelo de cliente
               //donde hago un "cast" que lo transforma en un booleano
               //no queda bonito pero es lo que hay
                ,
                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

                //el filtro booleano de abajo no funcion
                //     //aqui tengo que crear un filtro de multiple si es si o no 
                //                     //un filtro como booleano de si es multiple o no 
                //    BooleanConstraint::make('multiple')
                //    //No se is lo cogera como boolean,sino cambio por el ternario
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-m-pencil-square')
                    ->iconButton(),
                //primer intento de crear accion de eliminar con texto custom
                Action::make('Eliminar')
                    ->action(fn (Cliente $record) => $record->delete())
                    ->requiresConfirmation()
                    ->icon('heroicon-o-trash')
                    ->iconButton()
                    ->modalHeading('Eliminar Cliente')
                    ->modalDescription('Seguro que quiere eliminar este cliente?')
                    ->modalSubmitActionLabel('Sí, Eliminar Cliente')
                    ->modalCancelActionLabel('Cancelar')
                    ->color('danger')
                    ->modalIcon('heroicon-o-trash'),
            ], position: ActionsPosition::BeforeColumns)
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
