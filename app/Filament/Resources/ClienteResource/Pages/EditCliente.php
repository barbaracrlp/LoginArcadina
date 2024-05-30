<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use Filament\Actions;
use Filament\Forms\Form as FormsForm;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditCliente extends EditRecord
{
    protected static string $resource = ClienteResource::class;

    
    protected static ?string $title = 'Editar Cliente';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label("Eliminar"),
        ];
    }
 

}
