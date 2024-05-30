<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Ramsey\Uuid\Type\Integer;

enum EstadoPedido :int implements HasLabel,HasColor 
{

    case SIN_CONFIRMAR  = 0;
    case PENDIENTE_COBRO=1;
    case COBRADO=2;
    case PENDIENTE_PROCESO=3;
    case EN_PROCESO=4;
    case ENVIADO=5;
    case CANCELADO=6;
    case COMPLETADO=7;


    public function getLabel(): ?string
    {
        return match($this)
        {
            self:: SIN_CONFIRMAR  => 'Sin Confirmar',
            self:: PENDIENTE_COBRO=>'Pendiente de Cobro',
            self:: COBRADO=>'Cobrado',
            self:: PENDIENTE_PROCESO=>'Pendiente de Proceso',
            self:: EN_PROCESO=>'En proceso',
            self:: ENVIADO=>'Enviado',
            self:: CANCELADO=>'Cancelado',
            self:: COMPLETADO=>'Completado',
        };
    }


    /**Son los colores definidos en el Provider del Panel */
    public function getColor(): string|array|null
    {
        return match($this)
        {
            self:: SIN_CONFIRMAR  => 'sin',
            self:: PENDIENTE_COBRO=>'danger',
            self:: COBRADO=>'warning',
            self:: PENDIENTE_PROCESO=>'pendiente',
            self:: EN_PROCESO=>'info',
            self:: ENVIADO=>'enviado',
            self:: CANCELADO=>'neutral',
            self:: COMPLETADO=>'success',
        };
    }


}





















?>