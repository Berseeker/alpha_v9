@component('mail::message')
#Nueva cotización

Hecha por {{ $order->name . ' ' . $order->lastname}}

Productos: {{ $order->total_products }}
 
Alguien ha cotizado productos en la pagina!
 
@component('mail::button', ['url' => 'https://alphapromos.mx/login'])
Ver Cotizacion
@endcomponent
 
Gracias,<br>
{{ config('app.name') }}
@endcomponent