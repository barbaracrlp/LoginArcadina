<?php

namespace App\Models;

use App\Enums\EstadoPedido;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    //añadimos el primer modelo de pedidod generales

    protected $table='pedidos';

    const UPDATED_AT='f_modificacion';

    protected $fillable=[
        'total',
        'estado',
        'nombre',
        'direccion',
        'telefono',
        'comentario',
        'tipo',
        'notas',
    ]
    ;

    protected $casts= [
        'estado'=> EstadoPedido::class,
    ];

    //boot como tal no me hace falta tenerlo

}
