<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Scopes\AlbumScope;
use Illuminate\Database\Eloquent\Relations\HasMany;

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


     //relaciones con las etiquetas
     public function etiquetas()
     {
         return $this->hasManyThrough(Etiqueta::class, Tag_content::class, 'content_id', 'id', 'id', 'tag_id')
             ->where('tabla', 'albums');
     }
 
    public function labels(): HasMany
    {
        return $this->hasMany(Tag_content::class, 'content_id', 'id')->where('tabla', 'albums');
    }
  

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
