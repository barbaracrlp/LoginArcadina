<?php

namespace App\Filament\Pages\Auth;

class encriptaCliente {

    // No modificar, si se modifican dejarán de funcionar las codificaciones guardadas
    const METHOD     = 'AES-256-CBC';
    const SECRET_KEY = 'SAdP5 %XTgxe,BL7MoVA.2sr4uCZ_$3;bMz:;2SkCz,,ltuuWUjsqG-}yO44&D&<Y{BPUHvQ,Hb%@)#H t;|x[Gehu,Ic(JB[|K-<b%?Wa96_SmWV-;rC0AI7xP~T7+9';
    const SECRET_IV  = 'ksawdfhniu2345twqedfh343tsdlkfjf3wo123';
  
    private static $initiated = FALSE;
    private static $key;
    private static $iv;
  
    private static function init() {
  
      if (!self::$initiated) {
  
        // hash
        self::$key = hash('sha256', self::SECRET_KEY);
  
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        self::$iv = substr(hash('sha256', self::SECRET_IV), 0, 16);
  
        self::$initiated = TRUE;
  
      }
  
    }
  //para encriptar la contraseña del form
    public static function encripta($string) {
  
      self::init();
  
      // Encriptamos
      $string = openssl_encrypt($string, self::METHOD, self::$key, 0, self::$iv);
  
      // Codificamos con base64
      $string = base64_encode($string);
  
      // Añadimos marca
      return 'ssl:' . $string;
  
    }
  

    //desencriptar la contraseña de la DB para poder cambiarla
    public static function decrypt($crypt) {
  
      if (!self::check($crypt)) {
        return FALSE;
      }
  
      self::init();
  
      // Quitamos marca
      $crypt = mb_substr($crypt, 4);
  
      // Descodificamos desde base64
      $crypt = base64_decode($crypt);
  
      // Desencriptamos
      return openssl_decrypt($crypt, self::METHOD, self::$key, 0, self::$iv);
  
    }
  

    //verifica que la contraseña es la del cliente
    //de momento no hace falta ya que los clientes no pueden entrar aun al panel de gestiion
    public static function verify($crypt, $string) {
      if (($decrypt = self::decrypt($crypt)) === FALSE) {
        return FALSE;
      }
      return ($decrypt == $string);
    }
  
    public static function check($crypt) {
      // Pendiente: verificar que la cadena $crypt realmente ha sido cifrada con el METHOD y SECRET_KEY
      return mb_substr($crypt, 0, 4) === 'ssl:';
    }
  
  }

?>