@component('mail::message')
#Nuevo Mensaje
 
Alguien se ha puesto en contacto contigo!!
 
@component('mail::table')
| Campo         | Data          | 
| ------------- |:-------------:| 
| Nombre:       | {{$nombre}}   | 
| Email         | {{$email}}    | 
| Celular       | {{$celular}}  | 
| Comentarios   |{{$comentarios}}| 
@endcomponent
 
Gracias,<br>
{{ config('app.name') }}
@endcomponent