<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedioPago extends Model
{
    use HasFactory;

    protected $table='contenido';
    const UPDATED_AT = 'f_modi';
    const CREATED_AT ='f_crea';

    protected $fillable=[
        'titulo',
        'orden',
        'publicado',
    ];

    //relacion de que pertenece a un cliente
    public function pedido():BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }
}
