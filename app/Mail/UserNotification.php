<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $cotizacion;

    public function __construct($cotizacion)
    {
        $this->cotizacion = $cotizacion;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Mails.userNotification')
            ->subject('Cotizacion pendiente')
            ->from('noreply@alphapromos.mx', 'Alpha Promos')
            ->with([
                        'cotizacion' => $this->cotizacion,
                    ]);
    }
}
