<?php

namespace App\Models;

use App\Scopes\EtiquetaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    protected $table='contenido';

    const UPDATED_AT ='f_modi';

    protected $fillable= [
        'titulo',
        'contenido',
        'tipo',
        'f_modi',
        'publicado',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new EtiquetaScope);
    }

}
