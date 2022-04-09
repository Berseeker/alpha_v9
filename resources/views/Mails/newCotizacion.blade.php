@component('mail::message')
#Nueva cotización
 
Alguien ha cotizado prodcutos en la pagina!
 
@component('mail::button', ['url' => $url])
Ver Cotizacion
@endcomponent
 
Gracias,<br>
{{ config('app.name') }}
@endcomponent