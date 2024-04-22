<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table='det_pedidos';

    const UPDATED_AT ='f_modificacion';

    public function pedido():BelongsTo{
        return $this->belongsTo(Pedido::class);
    }
}
