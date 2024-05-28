<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    use HasFactory;

    protected $table='monedas';

    const UPDATED_AT =NULL;
    const CREATED_AT =NULL;

    protected $fillable= [
        'texto',
        'cod_paypal',//este se relaciona con los pedidos
        'simb_moneda',
    ];

}
