<?php

namespace App\Filament\Resources\PedidoResource\Pages;

use App\Filament\Resources\PedidoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use function Laravel\Prompts\alert;

class EditPedido extends EditRecord
{
    protected static string $resource = PedidoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    //ahora creo la funcion que antes de guardar el pedido se haga la llamada http al API
    protected function beforeSave():void
    {
        //aqui como tal va la llamada http 
        //para poder sacar el token de auth para el api, necesitare cambiar de alguna manera el login no sé como
   //si qeu funciona y redirije a la funcion que toca
    }

}
