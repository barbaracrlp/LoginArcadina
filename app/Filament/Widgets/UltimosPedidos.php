<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PedidoResource;
use App\Models\Pedido;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UltimosPedidos extends BaseWidget
{

    public function table(Table $table): Table
    {
        return $table
          
            ->query(Pedido::query()->latest('fecha')->limit(5))
            ->paginated(false)
            ->defaultSort('fecha','desc')
            ->columns([
                // ...
                Tables\Columns\TextColumn::make('numero')
                    ->label('Numero')
                    ->visibleFrom('md')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nombre')
                    ->label('Cliente')
                    ->sortable(),

                    Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->dateTime('Y-m-d')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')->sortable(),

                Tables\Columns\TextColumn::make('estado')
                    ->sortable()
                    ->badge(),
            ]);
    }
}
