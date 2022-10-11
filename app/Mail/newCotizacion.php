<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class newCotizacion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $url;
    protected $cotizacion;

    public function __construct($url,$cotizacion)
    {
        $this->url = $url;
        $this->cotizacion = $cotizacion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Mails.newCotizacion')
            ->with([
                        'cotizacion' => $this->cotizacion,
                        'url' => $this->url,
                    ]);
    }
}
