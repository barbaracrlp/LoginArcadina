<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//

class Album extends Model
{
    use HasFactory;

    protected $table='contenido';

    //funcion para sacar los albumes a partir de contenido
    public function contenido(){
        return $this->morphOne('App\Models\contenido','sacatipos');
    }

    public function scopeAlbums($query){
        return $query->whereHas('contenido',function($query){
            $query->where('tipo','album');
        });
    }
    //relacion de belongTo para contenido

    // public function contenido():BelongsTo{
    //     return $this->belongsTo(contenido::class);
    // }

    
}
