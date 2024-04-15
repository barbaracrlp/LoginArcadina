<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table='usuarios';

    protected $fillable = [
        'usuario',
        'mail',
        'pass',
        // Agrega aquí otras columnas si es necesario
    ];


}
