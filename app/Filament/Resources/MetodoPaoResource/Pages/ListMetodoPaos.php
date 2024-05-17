<?php

namespace App\Filament\Resources\MetodoPaoResource\Pages;

use App\Filament\Resources\MetodoPaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMetodoPaos extends ListRecords
{
    protected static string $resource = MetodoPaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
