<?php

namespace App\Filament\Resources\MetodoPaoResource\Pages;

use App\Filament\Resources\MetodoPaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMetodoPao extends EditRecord
{
    protected static string $resource = MetodoPaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
