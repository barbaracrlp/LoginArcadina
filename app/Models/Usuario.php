<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable implements FilamentUser
{
    use HasFactory;

    protected $table='usuarios';

/**en esta funcion sols poden accedir els usuaris amb nivell 9 o 10 */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->nivel == 9 || $this->nivel == 10;
    }
}
