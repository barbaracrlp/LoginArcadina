<?php

namespace App\Mail;

//le puedo pasar los objetos como tal y que el solo saque los datos
use App\Models\Usuario;
use App\Models\Cliente;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
//importo el de la direccion
use Illuminate\Mail\Mailables\Address;


class ClienteEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    //defino las variables
    public $asunto;
    public $contenido;
    public $usuario;
    public $cliente;



    public function __construct($asunto,$contenido,Usuario $usuario,Cliente $cliente)
    {
        //aqui deberia sacar las variables que le paso

        $this->asunto=$asunto;
        $this->contenido=$contenido;
        $this->usuario=$usuario;
        $this->cliente=$cliente;


    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->usuario->mail,$this->usuario->nombre),
            //para quien es 
            replyTo:[
                new Address($this->cliente->mail,$this->cliente->nombre),
            ],

            subject: $this->asunto, //en teoria aqui le paso el asunto del email
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Emails.email_cliente',
           
           //aqui le tengo que pasar los parametros que voy a usar en la vista del email como tal
            with:[
                'nombre'=>$this->cliente->nombre,
                'contenido'=>$this->contenido,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
