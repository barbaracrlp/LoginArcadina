<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable implements FilamentUser
{
    use HasFactory;

    protected $table='usuarios';

    protected $fillable = [
        'usuario',
        'mail',
        'pass',
        'nivel',
        // Agrega aquí otras columnas si es necesario
    ];

    // public function canAccessPanel(Panel $panel): bool{
    //     // return $this->nivel>=9;
    //     if ($this->email >=9){
    //         return true;
    //     }
    //     else return false;
    // }

    //solo puede acceder si el nivel es igual o mayor a 9
        public function canAccessPanel(Panel $panel): bool
        {
            return $this->nivel >=9 ;
        }

}
