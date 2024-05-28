<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PedidoResource\Pages;
use App\Filament\Resources\PedidoResource\RelationManagers;
use App\Filament\Resources\PedidoResource\RelationManagers\EtiquetasRelationManager;
use App\Models\Cliente;
use App\Models\Etiqueta;
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
use Filament\Forms\Get;
//importo los colores 
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;

//lo de la view Action Delete
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Enums\ActionsPosition;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Validation\ValidationException;

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
                Forms\Components\TextInput::make('numero')
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
                    ->inputMode('decimal')
                    ->suffixIcon('fas-euro-sign'),
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
                    ->label('Numero')
                    ->visibleFrom('md')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    //pongo un searchable por nombre para que sea más fácil que un filtro vamos
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->dateTime('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    //voy a crear enums para asi conseguir los colores siempre
                    //no se si funcionara
                    ->sortable()
                    ->badge(),
                // EstadoPedido::make('estado'),
                Tables\Columns\TextInputColumn::make('comentario')
                    ->label('Comentarios')
                    ->visibleFrom('xl')
                    ->sortable(),
                Tables\Columns\TextColumn::make('medioPago.titulo')
                    ->label('Metodo de Pago')
                    ->visibleFrom('md')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('etiquetas.titulo')
                //     ->label('Etiqueta'),
                /**Encontrar manera de que solo aparezca si se tiene etiquetas sino no */

                /**Por respetar el layout Filament no deja ocultar una columna solo en algunos casos
                 * como por ejemplo cuando no tenemos etiquetas
                 */
                Tables\Columns\TextColumn::make('etiquetas_count')
                    ->counts('etiquetas')
                    ->label('')
                    ->icon('fas-tag'),

            ])
            ->filters([

                SelectFilter::make('tipo')
                    ->multiple()
                    ->options([
                        'venta' => 'Venta',
                        'descarga' => 'Descarga',
                        'seleccion' => 'Seleccion',
                    ])->native(false),

                SelectFilter::make('cliente')
                    ->relationship('cliente', 'usuario')
                    ->searchable()
                    ->preload()
                    ->native(false),
                SelectFilter::make('medioPago')
                    ->relationship('medioPago', 'titulo')
                    ->searchable()
                    ->preload()
                    ->native(false),
                SelectFilter::make('estado')
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
                    ->native(false)
                    ->multiple(),
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
                //                  //ahora creo el primer filtro,por fecha
                //                  Filter::make('etiquetas.titulo')
                //                 ->form([
                //                     TextInput::make('etiqueta')->label('Etiquetas'),
                //                 ])
                //                 ->query(function (Builder $query, array $data) {

                //                     $etiqueta = $data['etiqueta'] ?? '';
                // return $query->where('etiquetas.titulo', 'like', '%' . $etiqueta . '%');
                //                 }),
                // SelectFilter::make('etiquetas')->relationship('etiquetas', 'titulo')
                //     ->native(false)
                //     ->preload(),
                /**El filtro anterior muestra solo las etiquetas presentes en la tabla
                 * el de a continuación presenta todas las de la app
                 */
                Filter::make('etiqueta')
                    ->form([
                        Select::make('etiqueta')
                            ->options(Etiqueta::all()->pluck('titulo', 'id')->toArray())
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['etiqueta'])) {
                            $etiquetaId = $data['etiqueta'];
                            return $query->whereHas('etiquetas', function (Builder $query) use ($etiquetaId) {
                                $query->where('id', $etiquetaId);
                            });
                        }
                        return $query;
                    }),




                Filter::make('fecha')
                    ->form([
                        DatePicker::make('created_from')->native(false)->label('Desde:'),
                        DatePicker::make('created_until')->native(false)->label('Hasta:'),
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







            ], layout: FiltersLayout::AboveContentCollapsible)


            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('fas-pen-to-square')
                    ->iconButton(),

                Tables\Actions\Action::make('Eliminar')
                ->icon('fas-trash')
                ->iconButton()
                ->modalAlignment(Alignment::Center)
                ->form([
                    \Filament\Forms\Components\Group::make([
                        TextInput::make('aleatorio')
                        ->readOnly()->label(''),
                        TextInput::make('numero')
                            ->label(''),
                    ])->columns(2),
                ])
                    ->fillForm(function (Pedido $record) {
                        return [
                            'aleatorio' => rand(1000, 9999),
                        ];
                    })
                    ->modalSubmitActionLabel('Eliminar')
                    ->modalCancelActionLabel('Cancelar')
                    ->color('danger')
                    ->modalContent(fn (Pedido $record,): View => view(
                        'filament.actions.deletePedido',
                        ['record' => $record,],
                    ))
                    ->action(function (array $data, Pedido $record): void {

                        $numero = $data['numero'];
                        $aleatorio = $data['aleatorio'];

                        if ($numero == $aleatorio) {
                            $record->delete();

                            Notification::make()
                                ->title('Eliminado Correctamente')
                                ->success()
                                ->persistent()
                                ->send();
                        }
                        else{
                            Notification::make()
                                ->title('Error al eliminar Pedido')
                                ->danger()
                                ->persistent()
                                ->send();
                        }
                    })

                // Tables\Actions\DeleteAction::make()
                // ->mountUsing(function (Form $form) {
                //     $form->fill(['secret' => strval(rand(1000, 9999))]);
                // })
                // ->form([
                //     Forms\Components\Placeholder::make('secret')
                //         ->content(fn(Get $get) => 'Please fill in this code to delete this record ' . $get('secret') ),
                //     Forms\Components\Hidden::make('secret'),
                //     Forms\Components\TextInput::make('code')
                //         ->label('Secret code')
                //         ->required(),
                // ])
                // ->action(function (array $data, Pedido $record): void {
                //     if ($data['code']!==$data['secret'])
                //     {
                //         throw ValidationException::withMessages([
                //             'mountedActionsData.0.code' => 'The secret code is invalid.',
                //         ]);
                //     }
              
                //     $record->delete();
              
                //     $this->redirect($this->getResource()::getUrl('index'));
                // })


            ], position: ActionsPosition::BeforeColumns)
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
