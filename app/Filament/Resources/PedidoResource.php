<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PedidoResource\Pages;
use App\Filament\Resources\PedidoResource\RelationManagers;
use App\Models\Pedido;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PedidoResource extends Resource
{
    protected static ?string $model = Pedido::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel= 'Pedidos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //agregamos los elementos del formulario
                Forms\components\TextInput::make('numero')
                ->disabled()
                ->label('Numero'),
                Forms\Components\TextInput::make('Nombre')
                ->disabled()
                ->label('Nombre'),
                DatePicker::make('fecha')
                ->label('Fecha')
                ->disabled()
                ->displayFormat('Y-m-d'),
                Forms\Components\TextInput::make('tipo')
                ->label('Tipo'),
                TextInput::make('total')
                ->label('Total')
                ->numeric()
                ->inputMode('decimal'),
                //para los estados voy a hacer un select
                


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
            'index' => Pages\ListPedidos::route('/'),
            'create' => Pages\CreatePedido::route('/create'),
            'edit' => Pages\EditPedido::route('/{record}/edit'),
        ];
    }
}
