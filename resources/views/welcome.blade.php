@extends('layouts.web')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/v3/home/index.css') }}">
@endsection

@section('content')
    <div class="container">
        @include('Home._partials.slider')
    </div> 

    <div class="container">
        <section class="row" id="catalogos">
            <div class="col-xs-12 col-sm-12 col-md-6 pd-0">
                <div class="item" style="background: url('{{ asset('imgs/v3/catalogos/botellas.jpeg') }}')">
                    <h2>Botellas y Bidones</h2>
                    <p>La mejor selección de botellas y bidones.</p>
                    <p class="mb-30">Personalizados con el logotipo de tu empresa</p>
                    <button class="btn-catalogo">Ver más</button>
                </div>  
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 pd-0">
                <div class="item" style="background: url('{{ asset('imgs/v3/catalogos/novedades.jpeg') }}')">
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
                <i class="fa-solid fa-handshake" style="color: #255992"></i>
                <h4>Atencion Eficáz</h4>
                <p>Atención personalizada, con asesorías para una inteligente selección, acorde a sus necesidades y presupuesto.</p>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3 features">
                <i class="fa-solid fa-shield" style="color: green;"></i>
                <h4>Experiencia</h4>
                <p>Con más de 25 años en el mercado. Hemos amalgamado la experiencia con las innovaciones del mundo actual.</p>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3 features">
                <i class="fa-solid fa-truck-ramp-box" style="color: brown"></i>
                <h4>Flete Grátis</h4>
                <p>A todo México en pedidos grandes.</p>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3 features">
                <i class="fa-solid fa-trophy" style="color:#ffd700;"></i>
                <h4>Confianza</h4>
                <p>Más de 200 compañías ya han confiado en nuestra experiencia.</p>
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
            <div class="swipert">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide cbox d-flex align-items-center"> <img src="{{ asset('imgs/v3/clientes/krystal_cancun.png') }}" class="clientes-img" alt=""> </div>
                    <div class="swiper-slide cbox d-flex align-items-center"> <img src="{{ asset('imgs/v3/clientes/marriot_logo.png') }}" class="clientes-img" alt=""> </div>
                    <div class="swiper-slide cbox d-flex align-items-center"> <img src="{{ asset('imgs/v3/clientes/oasis_logo.png') }}" class="clientes-img" alt=""> </div>
                    <div class="swiper-slide cbox d-flex align-items-center"> <img src="{{ asset('imgs/v3/clientes/palace_resort_logo.png') }}" class="clientes-img" alt=""> </div>
                    <div class="swiper-slide cbox d-flex align-items-center"> <img src="{{ asset('imgs/v3/clientes/paradisus_logo.jpeg') }}" class="clientes-img" alt=""> </div>
                    <div class="swiper-slide cbox d-flex align-items-center"> <img src="{{ asset('imgs/v3/clientes/park_logo.png') }}" class="clientes-img" alt=""> </div>
                    <div class="swiper-slide cbox d-flex align-items-center"> <img src="{{ asset('imgs/v3/clientes/presidente_logo.svg') }}" class="clientes-img" alt=""> </div>
                    <div class="swiper-slide cbox d-flex align-items-center"> <img src="{{ asset('imgs/v3/clientes/royalton_logo.png') }}" class="clientes-img" alt=""> </div>
                </div>
                <!-- If we need pagination -->
                <div class="swiper-paginationt"></div>
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prevt"></div>
                <div class="swiper-button-nextt"></div>
            </div>
        </section>
    </div>

@endsection

@section('page-scripts')

<script type="text/javascript">
    const swiper = new Swiper('.swiper', {
        // Optional parameters
        loop: true,

        // If we need pagination
        pagination: {
          el: ".swiper-pagination",
          type: "progressbar",
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    const swipert = new Swiper('.swipert', {
        // Optional parameters
        slidesPerView: 4,
        centeredSlides: true,
        spaceBetween: 10,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },

        // If we need pagination
        pagination: {
          el: ".swiper-paginationt",
          type: "progressbar",
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-nextt',
            prevEl: '.swiper-button-prevt',
        },
    });
</script>

@endsection



