<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class newMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $nombre;
    protected $email;
    protected $celular;
    protected $comentarios;

    public function __construct($nombre,$email,$celular,$comentarios)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->celular = $celular;
        $this->comentarios = $comentarios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Mails.newMessage')
            ->with([
                        'nombre' => $this->nombre,
                        'email' => $this->email,
                        'celular' => $this->celular,
                        'comentarios' => $this->comentarios,
                    ]);
    }
}
