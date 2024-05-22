<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PedidoResource\Pages;
use App\Filament\Resources\PedidoResource\RelationManagers;
use App\Filament\Resources\PedidoResource\RelationManagers\EtiquetasRelationManager;
use App\Models\Cliente;
use App\Models\MedioPago;
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
use Filament\Forms\Components\Select;
//para el filtro de las fechas
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
//añado la columna personalizada
use App\Tables\Columns\EstadoPedido;
use Filament\Forms\Components\Section;
//añado el filtro de select
use Filament\Tables\Filters\SelectFilter;
//el fieldset 
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
//importo los colores 
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;


class PedidoResource extends Resource
{
    protected static ?string $model = Pedido::class;

    protected static ?string $navigationIcon = 'fas-cart-shopping';

    protected static ?string $navigationLabel = 'Pedidos';

    protected static ?string $navigationGroup = "Tienda";



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //agregamos los elementos del formulario
                Forms\Components\ToggleButtons::make('estado')
                    ->options([
                        0 => 'Sin Confirmar',
                        1 => 'Pendiente de Cobro',
                        2 => 'Cobrado',
                        3 => 'Pendiente de Proceso',
                        4 => 'En Proceso',
                        5 => 'Enviado',
                        7 => 'Completado',
                        6 => 'Cancelado',
                    ])
                    //se pueden agregar tambien iconos, uno para cada opcion, pero ya 
                    //sobrecargaria el front (creo yo vamos)
                    ->colors([
                        0 => Color::Zinc,
                        1 => Color::Red,
                        2 => Color::Orange,
                        3 => Color::Purple,
                        4 => Color::Blue,
                        5 => Color::Green,
                        7 => color::Emerald,
                        6 => Color::Neutral,
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
                    ->disabled()
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
                        }
                    )
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
                    ->native(false),
                Select::make('id_mediopago')
                    ->relationship('medioPago', 'titulo')
                    ->searchable()
                    ->native(false)
                    ->preload(),
                Forms\components\TextInput::make('etiquetas.titulo'),
                // Select::make('')
                // ->relationship('etiquetas', 'titulo')
                // ->disabled()
                //     ->prefixIcon('fas-tag'),
                Section::make('Notas')
                    ->schema([
                        // ...
                        Textarea::make('comentario')->label('Comentario del cliente'),
                        Textarea::make('notas')->label('Notas'),

                    ])->collapsible()
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
                    ->label('Nombre')
                    //pongo un searchable por nombre para que sea más fácil que un filtro vamos
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->dateTime('Y-m-d'),
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo'),
                Tables\Columns\TextColumn::make('estado')
                    //voy a crear enums para asi conseguir los colores siempre
                    //no se si funcionara
                    ->badge(),
                // EstadoPedido::make('estado'),
                Tables\Columns\TextInputColumn::make('comentario')
                    ->label('Comentarios'),
                Tables\Columns\TextColumn::make('medioPago.titulo')
                    ->label('Metodo de Pago'),
                // Tables\Columns\TextColumn::make('etiquetas.titulo')
                //     ->label('Etiqueta'),
                /**Encontrar manera de que solo aparezca si se tiene etiquetas sino no */
                Tables\Columns\TextColumn::make('etiquetas_count')->counts('etiquetas')->label('')->icon('fas-tag'),
                // IconColumn::make('etiquetas.titulo')
                //     ->icon('fas-tag')->label(''),
            ])
            ->filters([
                //ahora creo el primer filtro,por fecha
                Filter::make('fecha')
                    ->form([
                        DatePicker::make('created_from')->native(false)->label('From:'),
                        DatePicker::make('created_until')->native(false)->label('Until:'),
                    ])->columns(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('fecha', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('fecha', '<=', $date),
                            );
                    }),

                SelectFilter::make('tipo')
                    ->multiple()
                    ->options([
                        'venta' => 'Venta',
                        'descarga' => 'Descarga',
                        'seleccion' => 'Seleccion',
                    ]),
                //me falta aqui la funcionalidad de que me de una lista con los clientes que haya
                // SelectFilter::make('cliente')
                // ->label('Cliente')
                // ->relationship('cliente', 'usuario')
                // ->searchable()
                // ->multiple(),
                SelectFilter::make('cliente')
                    ->relationship('cliente', 'usuario')
                    ->searchable()
                    ->preload(),
                Filter::make('comentario')
                    ->form([
                        TextInput::make('comentario')->label('Busca Comentario'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->where('comentario', 'like', '%' . $data['comentario'] . '%');
                    }),


                Filter::make('notas')
                    ->form([
                        TextInput::make('notas')->label('Buscar notas'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->where('notas', 'like', '%' . $data['notas'] . '%');
                    }),






            ], layout: FiltersLayout::AboveContentCollapsible)
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

            EtiquetasRelationManager::class,
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
