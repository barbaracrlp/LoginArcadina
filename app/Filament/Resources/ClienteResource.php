<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;

use App\Models\Cliente;

use Filament\Forms;

use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;



use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;

use Filament\Tables\Enums\ActionsPosition;


use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Mail;

use Filament\Tables\Filters\Filter;


use App\Filament\Pages\Auth\encriptaCliente;
use App\Mail\ClienteEmail;
use App\Models\Etiqueta;
use Filament\Forms\Components\Select;
use Filament\Tables\Enums\FiltersLayout;

use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Carbon;


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
                
                Tables\Columns\TextColumn::make('usuario')
                    ->label('Usuario')
                    ->grow(false)
                    ->sortable()
                    ->searchable(),
               
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
                
                ,
                Tables\Columns\TextColumn::make('mail') 
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
                    })
                    ->indicateUsing(function(array $data): ?string{
                        if(! $data['usuario']){
                            return null;
                        }
                        return 'Usuario: '.$data['usuario'];
                    }),

                Filter::make('nombre')
                    ->form([
                        TextInput::make('nombre')->label('Nombre'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->where('nombre', 'like', '%' . $data['nombre'] . '%');
                    })
                    ->indicateUsing(function(array $data): ?string{
                        if(! $data['nombre']){
                            return null;
                        }
                        return 'Nombre: '.$data['nombre'];
                    }),

                Filter::make('mail')
                    ->form([
                        TextInput::make('mail')->label('eMail'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->where('mail', 'like', '%' . $data['mail'] . '%');
                    })
                    ->indicateUsing(function(array $data): ?string{
                        if(! $data['mail']){
                            return null;
                        }
                        return 'Email: '.$data['mail'];
                    }),

                Filter::make('telefono')
                    ->form([
                        TextInput::make('telefono')->label('Teléfono'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->where('telefono', 'like', '%' . $data['telefono'] . '%');
                    })
                    ->indicateUsing(function(array $data): ?string{
                        if(! $data['telefono']){
                            return null;
                        }
                        return 'Tel: '.$data['telefono'];
                    }),

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
                    })
                    ->indicateUsing(function(array $data): ?string{
                        if(! $data['etiqueta']){
                            return null;
                        }
                        $etiqueta = Etiqueta::find($data['etiqueta']);
                        return $etiqueta ? 'Etiqueta: ' . $etiqueta->titulo : null;
                    }),

                Filter::make('acceso')
                    ->form([
                        Select::make('acceso')
                            ->options([

                                '0' => 'Hoy',
                                '1' => 'Ayer',
                                '7' => 'Últimos 7 días',
                                '15' => 'Últimos 15 días',
                                '30' => 'Últimos 30 días',
                                '30-90' => 'entre 30 y 90 días',
                                '90' => 'más de 90 días',
                                'N' => 'No ha accedido nunca',
                            ])
                            ->native(false)
                            ->label('Último acceso')
                    ])
                    ->query(function (Builder $query, array $data) {
                        $today = Carbon::today();
                        $yesterday = Carbon::yesterday();

                        switch ($data['acceso']) {
                            case '0': 
                                $query->whereDate('last_login', $today);
                                break;

                            case '1': 
                                $query->whereDate('last_login', $yesterday);
                                break;

                            case '7': 
                                $query->where('last_login', '>=', $today->subDays(7));
                                break;

                            case '15':
                                $query->where('last_login', '>=', $today->subDays(15));
                                break;

                            case '30': 
                                $query->where('last_login', '>=', $today->subDays(30));
                                break;

                            case '30-90': 
                                $query->whereBetween('last_login', [$today->subDays(90), $today->subDays(30)]);
                                break;

                            case '90': 
                                $query->where('last_login', '<', $today->subDays(90));
                                break;

                            case 'N': 
                                $query->whereNull('last_login');
                                break;
                        }
                        return $query;
                    })
                    ->indicateUsing(function(array $data): ?string{
                        if(! $data['acceso']){
                            return null;
                        }

                        switch ($data['acceso']) {
                            case '0':
                                return 'Hoy'; 
                                break;

                            case '1':
                                return 'Ayer'; 
                                break;

                            case '7':
                                return 'Últimos 7 días'; 
                                break;

                            case '15':
                                return 'Últimos 15 días';
                                break;

                            case '30':
                                return 'Últimos 30 días'; 
                                
                                break;

                            case '30-90':
                                return 'Entre 30 y 90 días'; 
                         
                                break;

                            case '90':
                                return 'Más de 90 días'; 
                            
                                break;

                        }
                    }),

                Filter::make('multiple')
                    ->query(fn (Builder $query): Builder => $query->where('multiple', 'si')),
      
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
               
                Tables\Actions\DeleteBulkAction::make()->label('Eliminar')
                    ->requiresConfirmation(),
                
            ]);
    }

   
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
            /**TODO: unir los clientes con pedidos por RelationManager
             *  Crearlo y después Definirlo
             * Definir las relaciones correctas en los modelos
             */
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientes::route('/'),
            // 'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
