<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreatedMail;

class OrderCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $tries = 5;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        //->cc(['alphapromos.rsociales@gmail.com','ventas@alphapromos.mx'])
        Mail::to('juan_alucard@hotmail.com')
            ->send(new OrderCreatedMail($event->order));
    }

    public function failed(OrderCreated $event, $exception)
    {
        $this->fail($exception);
        $this->fail($event->order->uuid);
    }
}
