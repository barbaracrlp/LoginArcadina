<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//importo lo que es la DB
use Illuminate\Support\Facades\DB;

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

    /**Primera funcion para crear un token nuevo */
    public static function newToken():bool
    {   

        //creo el token como tal
        $token= md5(uniqid('dinacms_token',true));

        error_log($token." <--token ");
        //creo la fecha de caducidad
        $caducity=date('Y-m-d H:i:s',strtotime('+24 hours'));
        error_log($caducity." <--token ");
         try{

            $insert=DB::table('auth_tokens')->insert([
                'userid'=>4,
                'token'=>$token,
                'caducity'=>$caducity
            ]);
            if (!$insert) {
                throw new Exception('Error inserting token into database.');
            }
            return (bool) $insert;
         }
         catch(Exception $e){
            error_log('Error creating the new Token '.$e->getMessage());
         }
    }
    /**necesito una funcion que me devuelva el token
     * primero que busque si hay uno, sino que cree otro , que al crearlo correctamente
     * me devuelva el token en si 
     */
    public static function getToken():String
    {

        $date=date('Y-m-d H:i:s', strtotime('+12 hours'));

        $token=DB::table('auth_tokens')
        ->select('token')
        ->where('userid','=',4)
        ->where('caducity','>',$date)
        ->orderBy('caducity')
        ->limit(1);

       error_log(json_encode($token));

        return 'el token se ha sacado';
    }

 
}
