<?php

namespace App\Filament\Resources\PedidoResource\Pages;

use App\Filament\Resources\PedidoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;

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
   //necesite la $data, té que estar guardat
   $url='aqui va la url del api"';
   //https:// Domain/gestion/api/tipollamada
   //el tipo de llamada en teoría es un submit

   //lo que necesitoe s como sacar el token de autentificacio per a poder conectarme al api
   //volver a mirar lo de conectar el api con lo de ronda solo para poner el API token 
   //luego hacer la llamada con este medoto? no sé si funcionara la verdad
   //vuelvo a mirar lo del api
   
    }

}
