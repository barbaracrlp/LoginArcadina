<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Token extends Model
{
    use HasFactory;
//en teoria esto no hace falta si creo las funciones que necesito
//y llamo directamente a la tabla desde la query pero porsi
    protected $table='auth_tokens';
    const UPDATED_AT=null;
    const CREATED_AT=null;

    protected $fillable=[
        'userid',
        'token',
        'caducity',
        'data',
    ];


    //en teoria esta relacion como tal no me haria falta pero porsi
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
