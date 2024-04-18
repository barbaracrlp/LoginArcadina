<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Scopes\AlbumScope;
//

class Album extends Model
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

    //funcion para sacar los albumes a partir de contenido

    //relacion de belongTo para contenido

    // public function contenido():BelongsTo{
    //     return $this->belongsTo(contenido::class);
    // }
    
        protected static function boot()
        {
            parent::boot();
            static::addGlobalScope(new AlbumScope);
        }
    //tengo que añadir un cast al booleano de publicado para que eloquent lo guarde bien

    protected $casts= [
        'publicado'=>'boolean',
    ];
}
