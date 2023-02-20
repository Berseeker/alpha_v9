<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\Order;

class OrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
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
        return $this->markdown('Mails.orderCreated')
            ->subject('Nueva Cotizacion')
            ->from('noreply@alphapromos.mx', 'Alpha Promos');
    }
}
