@extends('layouts.web')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/v3/home/welcome.css') }}">
    <script src="{{ asset('js/v3/easing/jquery_easing.js') }}"></script>
    <script src="{{ asset('js/v3/counter/counter.js') }}"></script>
@endsection

@section('content')

    @include('Home._partials.slider')


    <div class="container">
        <section class="row" id="catalogos">
            <div class="col-xs-12 col-sm-12 col-md-6 pd-0">
                <div class="item-catalogo" style="background: url('{{ asset('imgs/v3/catalogos/botellas.jpeg') }}')">
                    <h2>Botellas y Bidones</h2>
                    <p>La mejor selección de botellas y bidones.</p>
                    <p class="mb-30">Personalizados con el logotipo de tu empresa</p>
                    <button class="btn-catalogo">Ver más</button>
                </div>  
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 pd-0">
                <div class="item-catalogo" style="background: url('{{ asset('imgs/v3/catalogos/novedades.jpeg') }}')">
                    <h2>Novedades</h2>
                    <p>Consulta todas las novedades en Merchandising y</p>
                    <p class="mb-30">Artículos Promocionales para este 2023.</p>
                    <button class="btn-catalogo">Ver más</button>
                </div>
            </div>
        </section>
    </div>

    <div class="container">
        <section class="row" id="features-row">
            <div class="col-xs-12 col-sm-2 col-md-3 features">
                <i class="fa-solid fa-handshake-simple alpha-color"></i>
                <div id="counter">1</div>
                <h4>Atencion Eficáz</h4>
                <p>Atención personalizada, acorde a tus necesidades.</p>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3 features">
                <i class="fa-solid fa-money-bill-trend-up" style="color: green;"></i>
                <div id="counter-years">1</div>
                <h4>Experiencia</h4>
                <p>Con más de 25 años en el mercado.</p>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3 features">
                <i class="fa-solid fa-truck alpha-color"></i>
                <div id="counter-flete">1</div>
                <h4>Flete Incluido</h4>
                <p>Envíos a todo México sin pago extra.</p>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3 features">
                <i class="fa-solid fa-building" style="color: green;"></i>
                <div id="counter-confianza">1</div>
                <h4>Confianza</h4>
                <p>Más de 500 compañías ya han confiado en nuestra experiencia.</p>
            </div>
        </section>
    </div>

    <div class="container">
        <section id="categorias-destacadas">
            <h3>Categorias destacadas</h3>
            <div class="parent">
                <a href="{{ url('/categoria/tecnologia') }}" class="d-flex align-items-end child bg-one">
                    <p>Tecnología</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/boligrafos') }}" class="d-flex align-items-end child bg-two">
                    <p>Bolígrafos</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/relojes') }}" class="d-flex align-items-end child bg-three">
                    <p>Relojes</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/hogar') }}" class="d-flex align-items-end child bg-four">
                    <p>Hogar</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/oficina') }}" class="d-flex align-items-end child bg-three">
                    <p>Oficína</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/tecnologia') }}" class="d-flex align-items-end child bg-one">
                    <p>Tecnología</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/boligrafos') }}" class="d-flex align-items-end child bg-two">
                    <p>Bolígrafos</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/relojes') }}" class="d-flex align-items-end child bg-three">
                    <p>Relojes</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/hogar') }}" class="d-flex align-items-end child bg-four">
                    <p>Hogar</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/oficina') }}" class="d-flex align-items-end child bg-three">
                    <p>Oficína</p>
                </a>
            </div>
        </section>
    </div>

    <div class="container" style="overflow: hidden;">
        <section id="clientes">
            <h3>Clientes que confiaron en nosotros</h3>
            <div class="owl-carousel owl-theme clientes-slider">
                <!-- Slides -->
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/krystal_cancun.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/marriot_logo.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/oasis_logo.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/palace_resort_logo.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/paradisus_logo.jpeg') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/park_logo.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/presidente_logo.svg') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/royalton_logo.png') }}" class="clientes-img" alt=""> </div>
            </div>
        </section>
    </div>

@endsection

@section('page-scripts')

<script type="text/javascript">
$(document).ready(function (){

    $('.home-slider').owlCarousel({
        items:1,
    });

    $('.clientes-slider').owlCarousel({
        loop:true,
        nav:false,
        margin:10,
        responsiveClass:true,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:2
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        }
    });

    $("#counter").counter({
        autoStart: true,
        duration: 7000,
        countTo: 1024,
        placeholder: 0,
        easing: "easeOutCubic",
        onStart: function() {
          //document.getElementById("trigger").innerHTML = "Running.."
        },
        onComplete: function() {
          //document.getElementById("trigger").innerHTML = "Restart counting!"
        }
    });

    setCounter('counter', 7000, 1024);
    setCounter('counter-years', 10000, 25);
    setCounter('counter-flete', 7000, 3000);
    setCounter('counter-confianza', 9000, 500);
});

function setCounter(object, tiempo, hasta) {
    var counterObject = $('#' + object);
    counterObject.counter({
        autoStart: true,
        duration: tiempo,
        countTo: hasta,
        placeholder: 0,
        easing: "easeOutCubic",
        onStart: function() {
          //document.getElementById("trigger").innerHTML = "Running.."
        },
        onComplete: function() {
          //document.getElementById("trigger").innerHTML = "Restart counting!"
        }
    });
}
</script>

@endsection



