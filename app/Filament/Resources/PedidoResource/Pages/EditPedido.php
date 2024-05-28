<?php

namespace App\Filament\Resources\PedidoResource\Pages;

use App\Filament\Resources\PedidoResource;
use App\Models\Pedido;
use App\Models\Token;

use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;


use Filament\Support\Facades\FilamentView;
use Filament\Resources\Pages;
use Filament\Forms;
use Filament\Forms\Get;
use Illuminate\Validation\ValidationException;

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

            Actions\DeleteAction::make()
                ->mountUsing(function (Form $form) {
                    $form->fill(['secret' => strval(rand(1000, 9999))]);
                })
                ->form([
                    \Filament\Forms\Components\Group::make([
                        Forms\Components\Placeholder::make('secret')
                            ->content(fn (Get $get) => 'Por favor introduce el siguiente numero para confirmar ' . $get('secret')),
                        Forms\Components\Hidden::make('secret'),
                        Forms\Components\TextInput::make('code')
                            ->label('Número')
                            ->required(),
                    ]),

                ])
                ->action(function (array $data, Pedido $record): void {
                    if ($data['code'] !== $data['secret']) {
                        throw ValidationException::withMessages([
                            'mountedActionsData.0.code' => 'Número incorrecto',
                        ]);
                    }

                    //   $record->delete();
                    error_log('Lo borra');

                    $this->redirect($this->getResource()::getUrl('index'));
                })
                ->modalHeading('Eliminar Pedido')
                ->modalDescription('Eliminar el pedido implica eliminar todos los datos relacionados.')
                ->modalSubmitActionLabel('Sí, Eliminar Pedido')
                ->modalCancelActionLabel('Cancelar')
                ->label('Eliminar')
        ];
    }


    //copio en teoria la funcion original del vendor 

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {


        $data = $this->form->getState(afterValidate: function () {
            $this->callHook('afterValidate');
            $this->callHook('beforeSave');
        });

        $id_nuevo = $this->record->id;
        $estado_nuevo = $data['estado'];

        $data = json_encode($data);
        $data = json_decode($data, true);
        $data['id'] = $id_nuevo;

        $token = Token::getToken();
        error_log(' Token :' . $token);

        $data['auth_token'] = $token;

        $params = [];
        $params['auth_token'] = $token;
        $params['ajaxsubmit'] = 'pedido_estado';
        $params['estado'] = $estado_nuevo;
        $params['envia_mail'] = 'no';
        $params['id_pedido'] = $id_nuevo;


        $url_del_API = 'https://barbaratest01.arcadina.web2/gestion/api/ajaxsubmit.php';


        $respuesta = EditPedido::callApiHttpCambioEstado($url_del_API, $params, $timeout = 5);



        if ($shouldSendSavedNotification) {
            $this->getSavedNotification()?->send();
        }

        if ($shouldRedirect && ($redirectUrl = $this->getRedirectUrl())) {

            // error_log('entra aqui para redirigir');
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


    public function callApiHttpCambioEstado(string $url, array $params, int $timeout = 5): array
    {
        $ret = [
            'resultado' => 'nok',
            'mensaje' => '',
        ];

        try {

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
