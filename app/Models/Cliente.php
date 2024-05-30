<?php

namespace App\Models;

use App\Scopes\ClienteScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

//importo el nuevo archivo de encriptacion
use App\Filament\Pages\Auth\encriptaCliente;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    const UPDATED_AT = null;
    const CREATED_AT = null;


    protected $fillable = [
        'usuario',
        'mail',
        'nombre',
        'pass',
        'telefono',
        'direccion',
        'multiple',
        'last_login', 
    ];

 

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ClienteScope);
    }

    //defino la relacion a pedidos 
    public function pedido(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    //intento de transformar el multiple en un booleano
    public function getMultipleAttribute($value)
    {
        return $value === 'si' ? true : false;
    }

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }

    public function paisEnvio(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'envio_id_pais');
    }

    //relaciones con las etiquetas
    public function etiquetas()
    {
        return $this->hasManyThrough(Etiqueta::class, Tag_content::class, 'content_id', 'id', 'id', 'tag_id')
            ->where('tabla', 'clientes');
    }

   public function labels(): HasMany
   {
       return $this->hasMany(Tag_content::class, 'content_id', 'id')->where('tabla', 'clientes');
   }
 






    public function setTelefonoAttribute($value)
    {
        $this->attributes['telefono'] = ($value !== null) ? $value : '';
    }

    public function setDireccionAttribute($value)
    {
        $this->attributes['direccion'] = ($value !== null) ? $value : '';
    }

    /**voy a probar primero la de getpassatt a ver si así lo hace automatico y en la app misma
     * la coje asi, tengo que mirar si existe un metodo de set para hashear y cambiar
     */

    public function getPassAttribute($value)
    {
        //en value está lo que saca de la contraseña de la BD voy a ver que me saca exactamente
        //tengo que importar el nuevo archivo
        $contraseña= encriptaCliente::decrypt($value);

        // error_log('la contraseña que saca es : '.$contraseña);
        // error_log('la contraseña antigua es : '.$value);

        return $contraseña;
    }

    // public function setPassAttribute($value)
    // {
    //     $nuevaContraseña=encriptaCliente::encripta($value);
    //     error_log("lo que coje".$value);
    //     error_log('lo que devuelve '.$nuevaContraseña);

    //     return $nuevaContraseña;
    // }

    /**posible necesidad de recuperar contraseña y cambiar,reescribir todo lo del login pero con el metodo save tambien del pedido
     * creao aqui una funcion de contraseña para que la recupere como es puede que una funcion de set contraseña sirva para implementar el hashing también
     * 
     * public function getPassAttribute($value){
     * aqui va el dehahing para que la saque y se pueda cambiar}
     */



    public function hasheaPass($pass): string
    {
        return $pass;
    }
}
