<?php

namespace App\Models;

use App\Enums\EstadoPedido;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pedido extends Model
{
    use HasFactory;

    protected $table='pedidos';

    const UPDATED_AT='f_modificacion';

    protected $fillable=[
        'total',
        'estado',
        'nombre',
        'direccion',
        'localidad',
        'id_pais',
        'telefono',
        'email',
        'codpos',
        'comentario',
        'tipo',
        'notas',
        'id_usuario',
        'id_mediopago',
        'moneda', 
    ]
    ;

    protected $casts= [
        'estado'=> EstadoPedido::class,
    ];

    

    public function detallePedido():HasOne
    {
        return $this->hasOne(DetallePedido::class);
    }

    public function cliente():BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }


    public function medioPago(): BelongsTo
    {
        return $this->belongsTo(MedioPago::class, 'id_mediopago');
    }


     public function etiquetas()
     {
         return $this->hasManyThrough(Etiqueta::class, Tag_content::class, 'content_id', 'id', 'id', 'tag_id')
             ->where('tabla', 'pedidos');
     }

    public function labels(): HasMany
    {
        return $this->hasMany(Tag_content::class, 'content_id', 'id')->where('tabla', 'pedidos');
    }

    public function monedas():BelongsTo{
        return $this->belongsTo(Moneda::class,'moneda','cod_paypal');
    }

    public function getTotalAttribute(){
        // $precio = $this->attributes['total'];
        $precio = number_format($this->attributes['total'], 2);
        $simbolo=$this->monedas->simb_moneda;
        return $precio.'  '.$simbolo;

    }

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }
}
