<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    use HasFactory;
    protected $table='contenido';
    //buscar com posar la condicio de que es contenido on el tipo siga "gallery"
}
