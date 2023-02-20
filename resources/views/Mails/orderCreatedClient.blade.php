@component('mail::message')
Cotizacion Realizada

Hola {{ $order->name . ' ' . $order->lastname}}

Hemos recibido tu cotización, muy pronto alguien de nuestro staff se pondra en contacto contigo.

 
Gracias,<br>
{{ config('app.name') }}
@endcomponent