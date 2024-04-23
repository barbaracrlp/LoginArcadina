<?php

namespace App\Filament\Resources\PedidoResource\Pages;

use App\Filament\Resources\PedidoResource;
use App\Models\Token;
use Filament\Actions;
use Filament\Facades\Filament;
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

    //     //ahora creo la funcion que antes de guardar el pedido se haga la llamada http al API
    //     protected function beforeSave():void
    //     {
    //         //aqui como tal va la llamada http 
    //         //para poder sacar el token de auth para el api, necesitare cambiar de alguna manera el login no sé como
    //    //si qeu funciona y redirije a la funcion que toca
    //    //necesite la $data, té que estar guardat
    //    $url='http://localhost:3000/ajaxsubmit.php';

    //    //pongo la url del mocking
    //    //https:// Domain/gestion/api/tipollamada
    //    //el tipo de llamada en teoría es un submit

    //    //lo que necesitoe s como sacar el token de autentificacio per a poder conectarme al api
    //    //volver a mirar lo de conectar el api con lo de ronda solo para poner el API token 
    //    //luego hacer la llamada con este medoto? no sé si funcionara la verdad
    //    //vuelvo a mirar lo del api

    //     }


    //con estos metodos en teria se sobreescribe el metodo


    // protected function saving():void
    // {


    //     $data=$this->record->toArray();//aqui guardo todos los datos del formulario en uno

    //     $response=Http::post('http://localhost:3000/ajaxsubmit.php',$data);
    //     //en la peticion paso la url del APi y despues le paso el array con TODOS los datos
    //     //del record, que corresponde con el formulario del recurso

    //     if($response->successful()){
    //     // $responseData=$response->json();en esta linea tendria la respuesta, pero como tal no me hace falta
    //         //aqui tengo que buscar como redirigir otra vez a la página de

    //    alert('la respuesta es '.$response);

    //     /**Si es exitosa la peticion entonces guardo automaticamente */
    //      /**Al llamar al metodo original en teoria ya se redirije automaticamente
    //      * como en filament normal
    //      */
    //     parent::saving(); //guarda con los metodos normales, a la DB 
    //     //esto se podría quitar si no quieres cambiar directamente la DB

    //     }
    //     else
    //     {
    //         $errorResponse=$response->body();
    //         //muestro una ventana de error con el mensaje de error
    //         // Filament::component('edit-pedido')->message('Error al procesar la solicitud '.$errorResponse)
    //         // ->variant('danger');

    //         $this->addError('error','Error al procesar la Solicitud: '.$errorResponse);
    //     }
    // }

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

        error_log($id_nuevo);
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
         $token=Token::getToken();
         error_log(' Token :' . $token);
 
         $data['auth_token']=$token;//añado la variable nueva


        $dataFinal = json_encode($data);

        error_log($dataFinal);
       
        
        //$dataFinal son los parámetros que se envian a la API

        /**Aqui ya tengo que implementar la copia de lo que hace la funcion del codigo del doc de la API original */

        /**podria dividir la funcion de save en dos como tal, una donde saque los datos y devuelva todos los parametros
         * que necesito enviar al API
         * la otra donde realmente llame al api como en el DOC
         */
       


        //a la peticion le paso ya un JSON con los datos del formulario que no son disabled 
        //le añado a mano también el id del formulario
        /**posible solucion al token pasar datos del usuario aunque aun estoy iniciando session 
         * con los usuarios de Filament
         * no hubo manera de cambiar
         */




        /**Todo esto es la peticion, de momento me paro para ir probando lo del token
         * 
  
         */

        // $response=Http::post('http://localhost:3000/ajaxsubmit.php',$dataFinal);
        // error_log('Separacion');
        // error_log($response);
        // if($response->successful()){
        //     parent::save($shouldRedirect, $shouldSendSavedNotification);//aqui el parent save no me funciona  

        //     error_log('La petición fue exitosa.');
        // }
        // else{

        //     error_log('La petición falló: ' . $response->status());
        //     error_log('Separacion');
        //     error_log('La petición falló: ' . $response->body());

        //     $errorResponse=$response->body();
        //     //muestro una ventana de error con el mensaje de error
        //     // Filament::component('edit-pedido')->message('Error al procesar la solicitud '.$errorResponse)
        //     // ->variant('danger');

        //     $this->addError('error','Error al procesar la Solicitud: '.$errorResponse);
        // }

        /**Todo esto es la peticion, de momento me paro para ir probando lo del token 
         * 
         * 
         */
    }    //en el record tengo lo que son todos los datos de ese momento 
    //record es la instancia de pedido que hay 

}
