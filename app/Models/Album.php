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


    //relacion de belongTo para contenido

    public function contenido():BelongsTo{
        return $this->belongsTo(contenido::class);
    }
}
