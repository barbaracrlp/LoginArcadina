<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;

use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;

use Filament\Tables\Enums\ActionsPosition;

//los import necesarios para la accion de la columna del email
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Mail;

use Filament\Tables\Filters\Filter;

//importo la clase de encriptacion
use App\Filament\Pages\Auth\encriptaCliente;
use App\Mail\ClienteEmail;
use App\Models\Etiqueta;
use Filament\Forms\Components\Select;
use Filament\Tables\Enums\FiltersLayout;

use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class ClienteResource extends Resource
{



    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'fas-user-group';

    protected static ?string $navigationLabel = 'Clientes';

    protected static ?string $navigationGroup = "Ventas";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //agregamos el formulario 

                Forms\Components\Checkbox::make('multiple')
                    ->label('Usuario Múltiple')

                    ->autofocus(),
                Forms\Components\TextInput::make('usuario')
                    ->label('Nombre')
                    ->required()
                    ->autofocus(),
                Forms\Components\TextInput::make('pass')
                    ->label('Contraseña')
                    ->required()
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    /**la linea de abajo no deja guardar o 'deshidratar' si esta vacío */
                    ->dehydrateStateUsing(fn (string $state): string => encriptaCliente::encripta($state)),
                Forms\Components\TextInput::make('mail')
                    ->email()
                    ->label('Email')
                    ->required()
                    ->postfix('Máximo 10 direcciones separadas por comas'),
                Forms\Components\TextInput::make('telefono')
                    ->tel(),
                ComponentsSection::make('Dirección cliente')
                    ->schema([
                        Forms\Components\TextInput::make('direccion')
                            ->label('Direccion'),
                        Forms\Components\TextInput::make('codpos')
                            ->numeric()
                            ->label('Código Postal'),
                        Forms\Components\TextInput::make('localidad')
                            ->label('Localidad'),
                        Forms\Components\TextInput::make('provincia')
                            ->label('Provincia'),
                        //aqui necesito tener el select con todos los paises de la relacion
                        //mira el de veterinarios con los dueños es tal cual

                        //el pais no funciona 
                        Forms\Components\Select::make('pais_id')
                            ->relationship('pais', 'nombre_es')
                            ->searchable()
                            ->native(false)
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nombre_es')
                                    ->required()
                                    ->maxLength(255)
                            ]),
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // IconColumn::make('etiquetas.titulo')
                // ->icon('fas-tag')
                // ->color('primary')
                // ->label('')
                // ->size('sm'),
                Tables\Columns\TextColumn::make('usuario')
                    ->label('Usuario')
                    ->grow(false)
                    ->sortable()
                    ->searchable(),
                //agregamos las columnas de la tabla
                /**La primera opcion es mejor ya que enseña el numero de etiquetas
                 * si usamos el iconColumn tenemos un icono por cada etiqueta que hay
                 */
                Tables\Columns\TextColumn::make('etiquetas_count')
                    ->counts('etiquetas')
                    ->exists('etiquetas')
                    ->label('')
                    ->icon('fas-tag'),

                Tables\Columns\TextColumn::make('nombre')
                    ->grow(false)
                    ->label('Nombre')
                    ->sortable()
                    ->searchable()
                    ->visibleFrom('md'),

                Tables\Columns\TextColumn::make('last_login')
                    ->label('Último acceso')
                    ->dateTime('Y-m-d')
                    ->sortable(),

                Tables\Columns\CheckboxColumn::make('multiple')
                    ->disabled()
                    ->visibleFrom('md')
                    ->grow(false)
                //funciona haciendo una funcion en el modelo de cliente
                //donde hago un "cast" que lo transforma en un booleano
                //no queda bonito pero es lo que hay
                ,
                Tables\Columns\TextColumn::make('mail') //al email se le debe añadir una accion de enviar email
                    ->label('Email')
                    ->sortable()
                    ->searchable()
                    ->grow(false)
                    ->icon('fas-envelope')
                    //aqui le añado la accion de enviar el email,
                    ->action(
                        Action::make('sendEmail')

                            ->form([

                                TextInput::make('subject')->required()->label('Asunto'),
                                RichEditor::make('body')->required()->label('Mensaje:'),
                            ])
                            ->action(function (array $data, $record) {
                                Mail::to($record->mail)
                                    ->send(new ClienteEmail(
                                        $data['subject'],
                                        $data['body'],
                                        $record
                                    ));
                            })
                            ->modalHeading('Enviar Email:')

                    ),
                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable()
                    ->visibleFrom('md')
                    ->grow(false),


            ])
            ->filters([

                Filter::make('usuario')
                    ->form([
                        TextInput::make('usuario')->label('Usuario'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->where('usuario', 'like', '%' . $data['usuario'] . '%');
                    }),

                Filter::make('nombre')
                    ->form([
                        TextInput::make('nombre')->label('Nombre'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->where('nombre', 'like', '%' . $data['nombre'] . '%');
                    }),

                Filter::make('mail')
                    ->form([
                        TextInput::make('mail')->label('eMail'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->where('mail', 'like', '%' . $data['mail'] . '%');
                    }),

                Filter::make('telefono')
                    ->form([
                        TextInput::make('telefono')->label('Teléfono'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->where('telefono', 'like', '%' . $data['telefono'] . '%');
                    }),


                /**No se pueden mostrar todas las etiquetas de la app ya que filamet necesita tener 
                 * definida la relacion para no buscar directamente una columna en la BD
                 * Como mucho se podríasn poner todas pero desactivar de alguna manera las opciones no presentes en la tabla actual
                 * aunque no tendría demasiado sentido
                 * O crear un filtro custom 
                 */
                // SelectFilter::make('etiquetas')
                //     ->relationship('etiquetas', 'titulo')
                //     // ->options(Etiqueta::all()->pluck('titulo', 'id')->toArray())
                //     ->native(false)
                //     ->preload(),

                /**Intento de crear el filtro pers */

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

                /**Filtro de ultimo acceso */
                    
                // Filter::make('acceso')
                //     ->form([
                //         Select::make('acceso')
                //             ->options(
                //                 [
                //                     //valor=>etiqueta
                //                     $today=Carbon::now()->toDayDateTimeString() => 'Hoy',
                // // Carbon::yesterday()->toDateString() => 'Ayer',
                // // Carbon::today()->startOfWeek()->subDays(7)->toDateString() => 'Hace una semana',
                                

                //                 ]
                //             )
                //             ->native(false),
                //                 ]),
                    // ->query(function (Builder $query, array $data): Builder {
                    //     if (!empty($data['acceso'])) {
                    //         $etiquetaId = $data['acceso'];
                    //         return $query->whereHas('etiquetas', function (Builder $query) use ($etiquetaId) {
                    //             $query->where('id', $etiquetaId);
                    //         });
                    //     }
                    //     return $query;
                    // }),


                //primer filtro de multiple
                Filter::make('multiple')
                    ->query(fn (Builder $query): Builder => $query->where('multiple', 'si')),
                /**hará falta un filtro de ultimo acceso un selectfilter */


                /**El filtro de select para las fechas */


            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->icon('fas-pen-to-square')
                    ->iconButton()
                    ->color('neutral'),
                Tables\Actions\ViewAction::make()
                    ->icon('fas-eye')
                    ->color('info')
                    ->iconButton()
                    ->modalHeading('Información Cliente'),
                //primer intento de crear accion de eliminar con texto custom
                Action::make('Eliminar')
                    ->action(fn (Cliente $record) => $record->delete())
                    ->requiresConfirmation()
                    ->icon('fas-trash')
                    ->iconButton()
                    ->modalHeading('Eliminar Cliente')
                    ->modalDescription('Seguro que quiere eliminar este cliente?')
                    ->modalSubmitActionLabel('Sí, Eliminar Cliente')
                    ->modalCancelActionLabel('Cancelar')
                    ->color('danger')
                    ->modalIcon('fas-trash'),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()->label('Eliminar')
                    ->requiresConfirmation(),
                // ]),
            ]);
    }

    //aqui creo la infolist
    public static function infolist(Infolist $infolist): Infolist
    {

        return $infolist
            ->schema([
                Section::make('Información general')

                    ->schema([
                        TextEntry::make('nombre')->label('Nombre'),
                        TextEntry::make('usuario')->label('Usuario'),
                        TextEntry::make('telefono')->label('Telefono'),
                        TextEntry::make('mail')->label('Email'),
                        TextEntry::make('pass')->label('Contraseña'),
                    ])->columns(2),
                Section::make('Dirección')
                    ->schema([
                        TextEntry::make('direccion')->label('Dirección'),
                        TextEntry::make('codpos')->label('Código Postal'),
                        TextEntry::make('localidad')->label('Localidad'),
                        TextEntry::make('Provincia')->label('provincia'),
                        TextEntry::make('pais.nombre_es')->label('País'),
                        // TextEntry::make('etiqueta.titulo')->label('Etiqueta'),
                        //aquí va a tener que ir el país 
                        //necesito el modelo del pais que coj
                        TextEntry::make('usuario')->label('Usuario'),
                    ])->columns(3),

                /**Los apartados de envío no aparecen en el original */
                // Section::make('Envío')
                //     ->schema([
                //         Section::make('direccion Envío')
                //             ->schema([
                //                 TextEntry::make('envio_direccion')->label('Dirección'),
                //                 TextEntry::make('envio_codpos')->label('Código Postal'),
                //                 TextEntry::make('envio_localidad')->label('Localidad'),
                //                 TextEntry::make('envio_Provincia')->label('provincia'),
                //                 TextEntry::make('paisEnvio.nombre_es')->label('País'),
                //             ]),
                //         Section::make('Envío a : ')
                //             ->schema([
                //                 TextEntry::make('envio_nombre')->label('Nombre'),
                //                 TextEntry::make('envio_telefono')->label('Teléfono'),
                //             ]),
                //     ])->columns(3)
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //necesito crear un relationmanager para los pedidos
            /**necesitas definiar las funciones de ralcion en los modelos
         * despues crear el relation manager
         */
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
