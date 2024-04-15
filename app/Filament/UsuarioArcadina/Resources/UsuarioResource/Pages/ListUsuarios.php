<?php

namespace App\Filament\UsuarioArcadina\Resources\UsuarioResource\Pages;

use App\Filament\UsuarioArcadina\Resources\UsuarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsuarios extends ListRecords
{
    protected static string $resource = UsuarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
