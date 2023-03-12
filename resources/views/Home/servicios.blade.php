@extends('layouts.web')

@section('title', 'Servicios')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/v3/home/servicios.css') }}">
    <script src="{{ asset('js/v3/easing/jquery_easing.js') }}"></script>
@endsection

@section('content')

    <div class="container">
        <h1>Metodos de Impresión</h1>
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-4 mb-20">
                <img src="{{ asset('imgs/v3/servicios/bordado.jpeg') }}" class="metodo_impresion" alt="Bordado">
                <p class="metodo_impresion_text">Bordado</p>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 mb-20">
                <img src="{{ asset('imgs/v3/servicios/grabado_laser.jpeg') }}" class="metodo_impresion" alt="Grabado Laser">
                <p class="metodo_impresion_text">Grabado Láser</p>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 mb-20">
                <img src="{{ asset('imgs/v3/servicios/impresion_digital.jpeg') }}" class="metodo_impresion" alt="Impresion Digital">
                <p class="metodo_impresion_text">Impresión Digital</p>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 mb-20">
                <img src="{{ asset('imgs/v3/servicios/sandblast.jpeg') }}" class="metodo_impresion" alt="Sandblast">
                <p class="metodo_impresion_text">Sand Blast</p>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 mb-20">
                <img src="{{ asset('imgs/v3/servicios/serigrafia.jpeg') }}" class="metodo_impresion" alt="Serigrafia">
                <p class="metodo_impresion_text">Serigrafía</p>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 mb-20">
                <img src="{{ asset('imgs/v3/servicios/sublimacion.jpeg') }}" class="metodo_impresion" alt="Sublimacion">
                <p class="metodo_impresion_text">Sublimación</p>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 mb-20">
                <img src="{{ asset('imgs/v3/servicios/tampografia.png') }}" class="metodo_impresion" alt="Tampografia">
                <p class="metodo_impresion_text">Tampografía</p>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 mb-20">
                <img src="{{ asset('imgs/v3/servicios/vinil_textil.jpeg') }}" class="metodo_impresion" alt="Vinil Textil">
                <p class="metodo_impresion_text">Vinil Textil</p>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 mb-20">
                <img src="{{ asset('imgs/v3/servicios/gota_resina.webp') }}" class="metodo_impresion" alt="Gota de Resina">
                <p class="metodo_impresion_text">Gota de Resina</p>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    <!-- Scripts Draggable -->
    <script src="{{ asset('js/home/services/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/home/services/charming.min.js') }}"></script>
    <script src="{{ asset('js/home/services/bezier-easing.min.js') }}"></script>
    <script src="{{ asset('js/home/services/TweenMax.min.js') }}"></script>
    <script src="{{ asset('js/home/services/demo.js') }}"></script>
@endsection
