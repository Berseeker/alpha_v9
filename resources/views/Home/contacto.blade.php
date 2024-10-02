@extends('layouts/web')

@section('page-styles')
    <script src="https://www.google.com/recaptcha/api.js"></script>
     <script>
        function onSubmit(token) {
            document.getElementById("contacto").submit();
        }
    </script>
@endsection

@section('title', 'Contacto')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-6">
                <form action="{{ route('home.contacto') }}" id="contacto" method="POST" class="row">
                    @csrf
                    <h2 class="mb-4 col-xs-12 col-sm-12 col-lg-12">Contáctanos</h2>
                    <div class="form-group col-xs-12 col-sm-12 col-lg-6 mb-2">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="name" style="width: 100%;">
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-lg-6 mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" style="width: 100%;">
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-lg-6 mb-2">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="phone" style="width: 100%;">
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-lg-6 mb-2">
                        <label for="asunto" class="form-label">Asunto</label>
                        <input type="text" class="form-control" name="asunto" style="width: 100%;">
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-lg-12 mb-2">
                        <label for="comentarios" class="form-label">Comentarios</label>
                        <textarea name="comentarios" class="form-control" cols="30" rows="10" style="resize: none;width:100%;"></textarea>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-lg-12 mb-2">
                        <button class="g-recaptcha btn btn-outline-primary"
                        data-sitekey="6LfuzDQaAAAAAFxWRcVR1UYoU9waEmUtGZQKM_wl"
                        data-callback='onSubmit'
                        data-action='submit'>Enviar</button>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Información de Contacto</h4>
                        <p>Agradecemos te tomes unos minutos y nos cuentes tu experiencia, tus comentarios y sugerencias, eso ayudará a que cada día logremos ofrecer más y mejores servicios.</p>
                        <p>Correos electrónicos:</p>
                        <ul style="list-style: none">
                            <li><i class="fa-solid fa-envelope mr-10"></i><a href="mailto:ventas@alphapromos.mx">ventas@alphapromos.mx</a></li>
                        </ul>
                        <p>Cancún y Riviera Maya</p>
                        <ul style="list-style: none">
                            <li><i class="fa-solid fa-square-phone mr-10"></i>(998) 880-5111 / 880-5564 / 140-8894</li>
                        </ul>
                        <p>CDMX, México</p>
                        <ul style="list-style: none">
                            <li><i class="fa-solid fa-square-phone mr-10"></i>(55) 1106-6569</li>
                        </ul>
                        <p>Whatsapp</p>
                        <ul style="list-style: none">
                            <li><i class="fa-brands fa-whatsapp mr-10"></i>(+52) 998 111 1725</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-scripts')

@endsection
