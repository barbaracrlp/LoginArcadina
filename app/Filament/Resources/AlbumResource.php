<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlbumResource\Pages;
use App\Filament\Resources\AlbumResource\RelationManagers;
use App\Models\Album;
use App\Models\Etiqueta;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Laravel\SerializableClosure\Serializers\Native;

class AlbumResource extends Resource
{
    protected static ?string $model = Album::class;

    protected static ?string $navigationIcon = 'fas-film';

    protected static ?string $navigationLabel = 'Galerías';

    protected static ?string $navigationGroup = "Tienda";

    public static ?string $label = 'Galeria';



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
                    ->extraInputAttributes(['tabindex' => 1]),
                Forms\Components\TextInput::make('contenido'),
                Forms\Components\TextInput::make('tipo')
                    ->label('Tipo')
                    ->disabled(),
                DateTimePicker::make('f_modi')
                    ->label('Última modificacion')
                    ->disabled()
                    ->format('Y-m-d H:i:s'),
                Forms\Components\Toggle::make('publicado')
                    ->label('Publicado'),
                // ->onIcon('heroicon-s-eye')
                // ->offIcon('heroicon-m-eye-slash')
                // ->onColor('primary')
                // ->offColor('neutral'),
                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //las columnas 
                //ahora la columna
                IconColumn::make('etiquetas.titulo')
                    ->icon('fas-tag')->color('primary')->label(''),
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->sortable()
                    ->searchable(),
                //  Tables\Columns\CheckboxColumn::make('publicado'),
                Tables\Columns\ToggleColumn::make('publicado')
                    ->label('Publicado'),
                IconColumn::make('contenido')
                    ->options([
                        'fas-image' => 'foto',
                        'fas-circle-play' => 'video',
                    ]),
             
                Tables\Columns\TextColumn::make('fecha')
                    ->sortable()
                    ->dateTime('d-m-Y'),

            ])
            ->filters([
                Filter::make('titulo')
                    ->form([
                        TextInput::make('titulo')->label('Titulo'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->where('titulo', 'like', '%' . $data['titulo'] . '%');
                    })
                    ->indicateUsing(function(array $data): ?string{
                        if(! $data['titulo']){
                            return null;
                        }
                        return 'Titulo: '.$data['titulo'];
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

                    SelectFilter::make('publicado')
                    ->options([
                        true=> 'Publicado',
                        false => 'No Publicado',
                    ])
                    ->native(false),

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
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                 
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Desde: ' . Carbon::parse($data['created_from'])->format('d-m-Y');
                        }
                 
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Hasta: ' . Carbon::parse($data['created_until'])->format('d-m-Y');
                        }
                 
                        return $indicators;
                    }),


            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            // 'create' => Pages\CreateAlbum::route('/create'),
            // 'edit' => Pages\EditAlbum::route('/{record}/edit'),
        ];
    }
}
