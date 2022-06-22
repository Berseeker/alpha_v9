@extends('layouts.web')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/old/owl-carousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/old/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/home.css') }}">
@endsection

@section('content')

    @include('_partials.social')

    <div class="owl-carousel owl-theme custom-t">
        <a href="{{ asset('catalogos/futbol_2022.pdf') }}" target="_blank" class="item"><img src="{{ asset('imgs/slider/futbol_catalogo.jpg') }}" alt="" height="550px;" class="customImgSilder"></a>
        <a href="#" target="_blank" class="item"><img src="{{ asset('imgs/slider/agendas.png') }}" alt="" height="550px;" class="customImgSilder"></a>
        <a href="#" target="_blank" class="item"><img src="{{ asset('imgs/slider/verano.png') }}" alt="" height="550px;" class="customImgSilder"></a>
        <a href="#" target="_blank" class="item"><img src="{{ asset('imgs/slider/golf.png') }}" alt="" height="550px;" class="customImgSilder"></a>
    </div>


    <div class="content" style="display: -webkit-box;">
        <div class="grid">
            <figure class="effect-lily">
                <img src="{{ asset('imgs/dynamic_items/catalogo.jpeg') }}" alt="img12"/> <!-- 480 * 360 tamaño de las imagenes -->
                <figcaption>
                    <div>
                        <h2>Catalogo <span>{{ now()->year }}</span></h2>
                        <!--p>Lily likes to play with crayons and pencils</p-->
                    </div>
                    <a href="{{ asset('catalogos/futbol_2022.pdf') }}" target="_blank">View more</a>
                </figcaption>     
            </figure>
            <!--figure class="effect-oscar">
                <img src="{{ asset('imgs/dynamic_items/tequila.png') }}" alt="img1"/>
                <figcaption>
                    <div>
                        <h2>Tequila <span>Circulo</span></h2>
                    </div>
                    <a href="{{ asset('catalogos/circulo_tequila.pdf') }}" target="_blank">View more</a>
                </figcaption>     
            </figure-->
            <!--figure class="effect-layla">
                <img src="{{ asset('imgs/dynamic_items/covid_19.jpeg') }}" alt="img1"/>
                <figcaption>
                    <div>
                        <h2>Nice <span>Lily</span></h2>
                        <p>Lily likes to play with crayons and pencils</p>
                    </div>
                    <a href="{{ url('/subcategoria/articulos-contingencia') }}">View more</a>
                </figcaption>     
            </figure-->
            <figure class="effect-romeo">
                <img src="https://tympanus.net/Development/HoverEffectIdeas/img/2.jpg" alt="img02"/>
                <figcaption>
                    <h2>Alpha<span>Displays</span></h2>
                    <p>By<br>Jorge Galvan</p>
                    <a href="{{ route('home.displays') }}">View more</a>
                </figcaption>     
            </figure>
        </div>
    </div>

    <div class="features text-center">
        <div class="row">
        <div class="col-md-3">
            <div class="info">
            <div class="icon icon-info">
                <i class="fas fa-handshake" style="color: #255992;"></i>
            </div>
            <h4 class="info-title">Atención Eficaz </h4>
            <p>Atención personalizada, con asesorías para una inteligente selección, acorde a sus necesidades y presupuesto.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info">
            <div class="icon icon-info">
                <i class="material-icons" style="color: green;">verified_user</i>
            </div>
            <h4 class="info-title">Experiencia </h4>
            <p>Con más de 25 años en el mercado.  Hemos amalgamado la experiencia con las innovaciones del mundo actual.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info">
            <div class="icon icon-success">
                <i class="fas fa-truck" style="color:#00bcd4;"></i>
            </div>
            <h4 class="info-title">Flete Incluido</h4>
            <p>Envíos a todo México sin pago extra.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info">
            <div class="icon icon-rose">
                <i class="fas fa-bolt" style="color:red;"></i>
            </div>
            <h4 class="info-title">Pedidos Express</h4>
            <p>Entrega de 48-72 horas.</p>
            </div>
        </div>
        </div>
    </div>

    <h1 class="title-home">El artículo promocional by Alpha Promos</h1>
    <div class="divider-custom" style="color: #AADD35;">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
            <img src="{{ asset('imgs/logos/alpha_icon.png') }}" alt="" class="alpha_icon">
        </div>
        <div class="divider-custom-line"></div>
    </div>
    <div class="container box-us">
        <p>El artículo promocional te acompaña siempre, en tu hogar, oficina, automóvil, de viaje, en todo momento y lugar; es útil, atractivo y económico. En Alpha Promos nos dedicamos a resolver tus necesidades de artículos promocionales y de hotelería en todas las áreas comerciales de tu empresa.
        Contamos con una  amplia gama de artículos importados y de producción nacional que abarcan desde una libreta, agendas de oficina, hasta escenografías y displays, productos propios (mochilas, bolsas, hieleras, canguros, porta gafetes magnéticos, bolsas de lavandería) entre muchos otros.
        Si no encuentra lo que necesita en nuestra página web, se lo localizamos y cotizamos.</p>
    </div>

    <!--h1 class="title-home">Productos Destacados</h1>
    <div class="divider-custom" style="color: #AADD35;">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
            <img src="{{ asset('imgs/logos/alpha_icon.png') }}" alt="" class="alpha_icon">
        </div>
        <div class="divider-custom-line"></div>
    </div-->

@endsection

@section('page-scripts')
    <script src="{{ asset('js/old/owl-carousel/owl.carousel.min.js') }}"></script>
    <script>
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items:1,
            loop:true,
            margin:10,
            autoplay:true,
            autoplayTimeout:4000,
            autoplayHoverPause:true
        });
        $('.play').on('click',function(){
            owl.trigger('play.owl.autoplay',[1000])
        })
        $('.stop').on('click',function(){
            owl.trigger('stop.owl.autoplay')
        })
    </script>
@endsection


