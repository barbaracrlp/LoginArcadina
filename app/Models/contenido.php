<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class contenido extends Model
{
    use HasFactory;
    protected $table='contenido';
      // Cambio el nombre a ver si así si que lo cambia a la columna que toca
      const UPDATED_AT = 'f_mod';

    //añado las propiedades fillable
    /**se ve que al no haberlo hecho filament no puede saber qué propiedades son mass asignable
     * ponerlas en el array 
     */
    protected $fillable= [
        'titulo',
        'contenido',
        'tipo',
        'f_modi',
        'publicado',
    ];

    // Indica si el modelo debe registrar automáticamente las marcas de tiempo.
    // public $timestamps = false;


    //la relacion con los albumes
    //galeria de la parte de booking
    public function albums():HasMany{
        return $this->hasMany(Album::class);
    }
    //relacion con galeria, para luego
    //galeria de la parte de web
    public function galeries():HasMany{
        return $this->hasMany(Galeria::class);
    }
}
