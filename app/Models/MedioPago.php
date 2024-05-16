<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//el import para el scope
use App\Scopes\MetodoPagoScope;

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


    //ahora el metodo boot para usar el scope
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new MetodoPagoScope);
    }

    //relacion de que pertenece a un cliente
    public function pedido():BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    
}
