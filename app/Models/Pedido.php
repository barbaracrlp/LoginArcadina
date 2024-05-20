<?php

namespace App\Models;

use App\Enums\EstadoPedido;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'id_usuario',
        'id_mediopago', //tiene que ser fillable para que lo pueda coger s
    ]
    ;

    protected $casts= [
        'estado'=> EstadoPedido::class,
    ];

    //boot como tal no me hace falta tenerlo


    public function detallePedido():HasOne
    {
        return $this->hasOne(DetallePedido::class);
    }


    //defino la relacion de que un pedido pertenece a un usuarios
    //en los att fillable debo añadir usuario_id
    public function cliente():BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relacion de nuevo definiendo ahora belongsTo
    public function medioPago(): BelongsTo
    {
        return $this->belongsTo(MedioPago::class, 'id_mediopago');
    }

     // Definir la relación para obtener las etiquetas asociadas al pedido
     public function etiquetas()
     {
         return $this->hasManyThrough(Etiqueta::class, Tag_content::class, 'content_id', 'id', 'id', 'tag_id')
             ->where('tabla', 'pedidos');
     }

    public function labels(): HasMany
    {
        return $this->hasMany(Tag_content::class, 'content_id', 'id')->where('tabla', 'pedidos');
    }
}
