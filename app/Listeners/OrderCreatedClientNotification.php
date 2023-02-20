<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreatedClientMail;

class OrderCreatedClientNotification implements ShouldQueue
{
    use InteractsWithQueue;
    public $tries = 5;
    /**
     * Create the event listener.
     *
     * @return void
     */
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
         Mail::to($event->order->email)
            ->send(new OrderCreatedClientMail($event->order));
    }

    public function failed(OrderCreated $event, $exception)
    {
        $this->fail($exception);
        $this->fail($event->order->uuid);
    }
}
