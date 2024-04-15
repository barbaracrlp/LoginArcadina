<?php

namespace App\Filament\UsuarioArcadina\Resources\UsuarioResource\Pages;

use App\Filament\UsuarioArcadina\Resources\UsuarioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUsuario extends EditRecord
{
    protected static string $resource = UsuarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
