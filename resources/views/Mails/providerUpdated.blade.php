@component('mail::message')

Hola 

El proveedor {{ $provider }} se actualizo de manera correcta.

 
Gracias,<br>
{{ config('app.name') }}
@endcomponent