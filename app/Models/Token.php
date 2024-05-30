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

    protected $table = 'auth_tokens';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'userid',
        'token',
        'caducity',
        'data',
    ];


    //en teoria esta relacion como tal no me haria falta pero porsi
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

 

    /**Primera funcion para crear un token nuevo y devuelve el token */
    public static function newToken(): String
    {
        //como me crea el token y sé que funciona no hace falta que me devuelva un booleano
        //sino que me puede devolver directamente el token que se añade a la DB

        //creo el token como tal
        $token = md5(uniqid('dinacms_token', true));

       
        //creo la fecha de caducidad
        $caducity = date('Y-m-d H:i:s', strtotime('+24 hours'));
       
        try {

            $insert = DB::table('auth_tokens')->insert([
                'userid' => 4,
                'token' => $token,
                'caducity' => $caducity
            ]);
            if (!$insert) {
                throw new Exception('Error inserting token into database.');
            }
            return  $token;
        } catch (Exception $e) {
            error_log('Error creating the new Token ' . $e->getMessage());
        }
    }

    /**funcion que busca en la base de datos si hay token válido 
     * si no lo hay crea uno nuevo y lo añade a la BD
     */
    public static function getToken(): String
    {

        $date = date('Y-m-d H:i:s', strtotime('+12 hours'));
       
        $token = DB::table('auth_tokens')
            ->select('token')
            ->where('userid', '=', 4)
            ->where('caducity', '>', $date)
            ->orderBy('caducity')
            ->limit(1)
            ->value('token');

        if ($token === null)
        {
            $token=Token::newToken();
           
        }
        
        return $token;
        
    }
}
