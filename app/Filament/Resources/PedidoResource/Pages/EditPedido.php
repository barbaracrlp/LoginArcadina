<?php

namespace App\Filament\Resources\PedidoResource\Pages;

use App\Filament\Resources\PedidoResource;
use App\Models\Token;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;


use Filament\Support\Facades\FilamentView;
use Filament\Resources\Pages;
//importo la view 

use function Laravel\Prompts\alert;
use function Laravel\Prompts\error;

class EditPedido extends EditRecord
{
    protected static string $resource = PedidoResource::class;

    protected static ?string $title = 'Edición de Pedido';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }


    //copio en teoria la funcion original del vendor 

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {



        error_log('Guardando registro...');
        //aqui no tengo que guardar el record sino el estado del formulario
        $data = $this->form->getState(afterValidate: function () {
            $this->callHook('afterValidate');
            $this->callHook('beforeSave');
        });

        $id_nuevo = $this->record->id;
        $estado_nuevo = $data['estado'];
        //aqui tengo guardado el estado nuevo
        error_log($id_nuevo . "<--aqui esta el id en teoria");
        error_log("estado nuevo: " . $estado_nuevo);

        // $data=$this->record->toArray();//aqui guardo todos los datos del formulario en uno
        error_log(json_encode($data));
        error_log('arriba esta la variable que saca del formulario');
        /**aqui saco los datos del formulario y le añado las variables que sean necesario añadir para 
         * hacer la peticion 
         * 
         */
        $data = json_encode($data); //guardo todo el formulario como   json
        $data = json_decode($data, true); //a arreglo asociativo
        $data['id'] = $id_nuevo; //añado la variable nueva

        //busco el token
        $token = Token::getToken();
        error_log(' Token :' . $token);

        $data['auth_token'] = $token; //añado la variable nueva
        //necesito definir una variable que sea un array donde guarde los parámetros a pasar 
        $params = [];
        $params['auth_token'] = $token; //le agrego el token
        $params['ajaxsubmit'] = 'pedido_estado';
        $params['estado'] = $estado_nuevo;
        $params['envia_mail'] = 'no';
        $params['id_pedido'] = $id_nuevo;


        //tengo que hacer la variable de parametros como form-urlundercoded 
        //nueva variable parametros 
        $parametros = [
            'auth_token' => $token,
            'ajaxsubmit' => 'pedido_estado',
            'estado' => $estado_nuevo,
            'envia_mail' => 'no',
        ];


        error_log(json_encode($params) . "<--aqui estan los parametros peronjsonencode");
        $url_del_API = 'https://barbaratest01.arcadina.web2/gestion/api/ajaxsubmit.php';


        $respuesta = EditPedido::callApiHttpCambioEstado($url_del_API, $params, $timeout = 5);
        error_log(json_encode($respuesta));




        //llamo al API que en teoria hace lo que tiene que hacer
        //ahora redirijo cogiendo el final de la funcion original del vendor
        if ($shouldSendSavedNotification) {
            $this->getSavedNotification()?->send();
        }

        if ($shouldRedirect && ($redirectUrl = $this->getRedirectUrl())) {

            error_log('entra aqui para redirigir');
            $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && $this->is_app_url($redirectUrl));
        }
    }


    /**Las dos funciones siguientes son para redirigir a la lista de pedidos cuando esta se haya actualizado */
    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index');
    }

    function is_app_url(string $url): bool
    {
        return str($url)->startsWith(request()->root());
    }


    //en el record tengo lo que son todos los datos de ese momento 
    //record es la instancia de pedido que hay 

    public function callApiHttpCambioEstado(string $url, array $params, int $timeout = 5): array
    {
        $ret = [
            'resultado' => 'nok',
            'mensaje' => '',
        ];

        try {
            // $response = Http::timeout($timeout)->post($url, $params);
            //withoutverifying para evitar el error de acceso de ssl
            // $response = Http::withoutVerifying()->timeout($timeout)->post($url, $params);
            //tengo que cambiar la forma en la que hace la peticion
            $response = Http::asForm()->withoutVerifying()->timeout($timeout)->post($url, $params);

            $statusCode = $response->status();
            $json = '';
            $ret = null;

            if ($statusCode == 200) { // Si el status es OK
                $json = $response->body(); // Intentamos recuperar el cuerpo de la respuesta
                if ($json !== '') { // Si lo hemos podido recuperar
                    $tmp = json_decode($json, true); // Lo decodificamos desde JSON a un array
                    if ($tmp === null) {
                        $lastError = "{$url} no devolvió JSON válido";
                    } elseif (is_array($tmp)) {
                        $ret = $tmp;
                        $lastError = "";
                    }
                } else {
                    $lastError = "{$url} no devolvió JSON";
                }
            } else {
                $reasonPhrase = $response->statusText();
                $lastError = "{$url} falló. Status code: {$statusCode} - {$reasonPhrase}";
            }
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $lastError = $e->getMessage();
        } catch (\Throwable $th) {
            $lastError = $th->getMessage();
        }

        if ($lastError != '') {
            $ret = [
                'resultado' => 'nok',
                'mensaje' => $lastError,
            ];
        }

        return empty($ret) ? [] : $ret;
    }

}
