<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PedidoResource\Pages;
use App\Filament\Resources\PedidoResource\RelationManagers;
use App\Models\Pedido;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Carbon\Carbon;



//importo los colores 
use Filament\Support\Colors\Color;

class PedidoResource extends Resource
{
    protected static ?string $model = Pedido::class;

    protected static ?string $navigationIcon = 'fas-cart-shopping';

    protected static ?string $navigationLabel= 'Pedidos';

    protected static ?string $navigationGroup = "Tienda";

   

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //agregamos los elementos del formulario
                Forms\Components\ToggleButtons::make('estado')
                ->options([
                    0=>'Sin Confirmar',
                    1=>'Pendiente de Cobro',
                    2=>'Cobrado',
                    3=>'Pendiente de Proceso',
                    4=>'En Proceso',
                    5=>'Enviado',
                    7=>'Completado',
                    6=>'Cancelado',  
                ])
                //se pueden agregar tambien iconos, uno para cada opcion, pero ya 
                //sobrecargaria el front (creo yo vamos)
                ->colors([
                    0=>Color::Zinc,
                    1=>Color::Red,
                    2=>Color::Orange,
                    3=>Color::Purple,
                    4=>Color::Blue,
                    5=>Color::Green,
                    7=>color::Emerald,
                    6=>Color::Neutral,  
                ])
                ->inline()
                // ->grouped()
                ->columnSpanFull()
                // ->prefixAction(
                //     Action::make('cambiaEstado')
                //     ->action(
                //         function ( ){
                //             //aqui en teoria tengo que definir la accion que hace la peticion al htt
                //         }
                //     )
                // )
                ,
                Forms\components\TextInput::make('numero')
                ->disabled()
                ->label('Numero'),
                Forms\Components\TextInput::make('nombre')
                ->disabled()
                ->label('Nombre'),
                DatePicker::make('fecha')
                ->label('Fecha')
                //a ver si asi se cambia el datePicker
                ->native(false)
                ->disabledDates(
                    function () {
                        $pastDates = [];
                        $currentDate = Carbon::now();
                        
                        // Generate past dates
                        for ($i = 1; $i <= 60; $i++) { // You can adjust the number of past days as needed
                            $pastDates[] = $currentDate->subDay()->format('Y-m-d');
                        }
                        
                        return $pastDates;
                })
                //->disabled()
                ->displayFormat('Y-m-d'),
                Forms\Components\TextInput::make('tipo')
                ->label('Tipo'),
                TextInput::make('total')
                ->label('Total')
                ->numeric()
                ->inputMode('decimal'),
                //para los estados voy a hacer un select
                //al final cambio a togglebuttons pero no se si se podran definir las acciones
                //si no se pueden será mejor dejarlo como select y ya 
                DatePicker::make('f_modificacion')
                ->label('Última modificacion')
                ->disabled()
                ->displayFormat('Y-m-d')
                ,
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //Ahora las columnas iguales que lo otro
                Tables\Columns\TextColumn::make('numero')
                ->label('Numero'),
                Tables\Columns\TextColumn::make('nombre')
                ->label('Nombre'),
                Tables\Columns\TextColumn::make('fecha')
                ->label('Fecha')
                ->dateTime('Y-m-d'),
                Tables\Columns\TextColumn::make('tipo')
                ->label('Tipo'),
                Tables\Columns\TextColumn::make('estado')
                //voy a crear enums para asi conseguir los colores siempre
                //no se si funcionara
                ->badge(),
                Tables\Columns\TextInputColumn::make('comentario')
                ->label('Comentarios'),


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
            // 'create' => Pages\CreatePedido::route('/create'),
            'edit' => Pages\EditPedido::route('/{record}/edit'),
        ];
    }

    
}
