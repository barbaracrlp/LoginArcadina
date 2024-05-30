<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AlbumResource;
use App\Filament\Resources\PedidoResource;
use App\Models\Album;
use Filament\Forms\Components\Builder;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UltimasGalerias extends BaseWidget
{


    // protected int | string | array $columnSpan =2;

    public function table(Table $table): Table
    {
        return $table
        ->query(Album::query()->latest('fecha')->limit(5))
        ->paginated(false)
        ->defaultSort('fecha','desc')
            ->columns([
                // ...
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->limit(30)
                    ->sortable(),
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
            ]);
    }


}
