<?php

namespace App\Models;

use App\Scopes\ClienteScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table='usuarios';
    const UPDATED_AT = null;
    const CREATED_AT = null;


    //aqui a lo mejor para la implementacion posterior 
    //hace falta añadir más datos de la tabla
    //de momento con estos me sobra
    protected $fillable=[
        'usuario',
        'mail',
        'telefono',
        'direccion',
    ];

    //ahora la funcion para utilizar el scope como tal

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ClienteScope);
    }


}
