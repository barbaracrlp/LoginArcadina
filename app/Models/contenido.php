<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class contenido extends Model
{
    use HasFactory;
    protected $table='contenido';

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
