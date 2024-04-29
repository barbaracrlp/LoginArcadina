<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

//importo el modelo de HAsName
// use Filament\Filament\Panelists\Concerns\HasName;
use Filament\Models\Contracts\HasName as ContractsHasName;

class Usuario extends Authenticatable implements FilamentUser,ContractsHasName
{
    use HasFactory;

    protected $table='usuarios';

    //relleno los campos de la tabla que son para usar
    protected $fillable=[
        'usuario',//nombre
        'mail',
        'pass',//contraseña
        'nivel',//nivel para poder acceder
    ];

    //copio del original los hidden
    protected $hidden=[
        'pass',
    ];


    //ahora los casts para ser capaces de hashear la contraseña
    protected function casts():array
    {
        return [
            'pass'=>'hashed',
        ];
    }

/**en esta funcion sols poden accedir els usuaris amb nivell 9 o 10 */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->nivel == 9 || $this->nivel == 10;
    }


    /**ahora la funcion para sacar el nombre de la tabla */

    public function getFilamentName(): string
    {
        return $this->getAttribute('usuario');
    }
}
