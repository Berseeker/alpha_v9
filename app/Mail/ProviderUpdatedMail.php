<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;


class ProviderUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $provider;

    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function envelope()
    {
        return new Envelope(
            from: new Address('noreply@alphapromos.mx', 'NoReply Alpha'),
            subject: 'Nueva Cotizacion',
        );
    }


    public function build()
    {
        return $this->markdown('Mails.providerUpdated')
            ->subject('Proveedor Actualizado')
            ->from('noreply@alphapromos.mx', 'Alpha Promos');
    }
}
