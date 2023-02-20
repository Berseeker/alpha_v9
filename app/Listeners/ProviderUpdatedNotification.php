<?php

namespace App\Listeners;

use App\Events\ProviderUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProviderUpdatedMail;

class ProviderUpdatedNotification implements ShouldQueue
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
     * @param  \App\Events\ProviderUpdated  $event
     * @return void
     */
    public function handle(ProviderUpdated $event)
    {
         Mail::to('juan.alucard.02@gmail.com')
            ->send(new ProviderUpdatedMail($event->provider));
    }

    public function failed(ProviderUpdated $event, $exception)
    {
        $this->fail($exception);
        $this->fail('Error al mandar mail del proveedor: ' . $event->provider);
    }
}
