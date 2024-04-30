<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    //DEfino la tabla y los timestamps

    protected $table='paises';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable=[
        'id',
        'nombre_es',
        'nombre_en',
        'nombre_it',
        'nombre_pt',
        'codPais',
        'esUE',//este es el booleano de si pertenece o no a la union europea
    ];

}
