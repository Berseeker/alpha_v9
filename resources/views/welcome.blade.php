@extends('layouts.web')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/v3/home/home_page.css') }}">
    <script src="{{ asset('js/v3/easing/jquery_easing.js') }}"></script>
    <script src="{{ asset('js/v3/counter/counter.js') }}"></script>
@endsection

@section('content')

    @include('Home._partials.slider')


    <div class="container">
        <section class="row catalogos-home">
            <div class="col-xs-12 col-sm-12 col-md-6 pd-0">
                <div class="item-catalogo" style="background: url('{{ asset('imgs/v3/catalogos/termos.png') }}')">
                    <h2>Termos</h2>
                    <p>La mejor selección de termos.</p>
                    <p class="mb-30">Personalizados con el logotipo de tu empresa</p>
                    <a href="{{ url('bebidas//subcategoria/termo-metalico') }}" style="text-decoration: none;" class="btn-catalogo">Ver más</a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 pd-0">
                <div class="item-catalogo" style="background: url('{{ asset('imgs/v3/catalogos/novedades.png') }}')">
                    <h2>Novedades</h2>
                    <p>Consulta todas las novedades</p>
                    <p class="mb-30">Artículos Promocionales para este 2023.</p>
                    <a href="{{ url('/') }}" class="btn-catalogo">Ver más</a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 pd-0">
                <div class="item-catalogo" style="background: url('{{ asset('imgs/v3/catalogos/sublimacion.png') }}')">
                    <h2>Sublimación</h2>
                    <p>La mejor selección de articulos.</p>
                    <p class="mb-30">Personalizados con el logotipo de tu empresa</p>
                    <a href="{{ url('/categoria/sublimacion') }}" class="btn-catalogo">Ver más</a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 pd-0">
                <div class="item-catalogo" style="background: url('{{ asset('imgs/v3/catalogos/tecnology.png') }}')">
                    <h2>Tecnología</h2>
                    <p>Descubre lo mejor para ti.</p>
                    <p class="mb-30">Artículos Promocionales para este 2023.</p>
                    <a href="{{ url('/categoria/tecnologia') }}" class="btn-catalogo">Ver más</a>
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
                <a href="{{ url('/categoria/boligrafos') }}" class="d-flex align-items-end child bg-one">
                    <p>Bolígrafos</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/ecologicos') }}" class="d-flex align-items-end child bg-two">
                    <p>Ecológicos</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/herramientas') }}" class="d-flex align-items-end child bg-three">
                    <p>Herramientas</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/hogar') }}" class="d-flex align-items-end child bg-four">
                    <p>Hogar</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/oficina') }}" class="d-flex align-items-end child bg-five">
                    <p>Oficína</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/paraguas') }}" class="d-flex align-items-end child bg-six">
                    <p>Paraguas</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/salud-y-cuidado-personal') }}" class="d-flex align-items-end child bg-seven">
                    <p>Salud</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/tecnologia') }}" class="d-flex align-items-end child bg-eight">
                    <p>Tecnología</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/textil') }}" class="d-flex align-items-end child bg-nine">
                    <p>Textil</p>
                </a>
            </div>
            <div class="parent">
                <a href="{{ url('/categoria/viaje') }}" class="d-flex align-items-end child bg-ten">
                    <p>Viaje</p>
                </a>
            </div>
        </section>
    </div>

    <div class="container" style="overflow: hidden;">
        <section id="clientes">
            <h3>Clientes que confían en nosotros</h3>
            <div class="owl-carousel owl-theme clientes-slider">
                <!-- Slides -->
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/grand_vela_cabos.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/grand_vela_riviera.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/grupo_anderson.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/grupo_xcaret.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/hardrock_logo.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/hilton_logo.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/lagunamar_westin.webp') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/nickelodeon_logo.svg') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/ocean_logo.svg') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/palladium_hotel.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/palace_resort_logo.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/paradisus_logo.jpeg') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/park_royal_cancun.webp') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/park_royal_hotels.jpeg') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/presidente_logo.svg') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/presidente_cozumel_hotel.svg') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/rdc_hotel.webp') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/royalton_logo.png') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/breathless.jpeg') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/sandos.webp') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/atelier.jpeg') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/excellence.webp') }}" class="clientes-img" alt=""> </div>
                <div class="item cbox d-flex align-items-center justify-content-center"> <img src="{{ asset('imgs/v3/clientes/secrets.png') }}" class="clientes-img" alt=""> </div>
            </div>
        </section>
    </div>

@endsection

@section('page-scripts')

<script type="text/javascript">
$(document).ready(function (){

    $('.home-slider').owlCarousel({
        loop:true,
        responsiveClass:true,
        autoplay:true,
        autoplayTimeout:4000,
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



