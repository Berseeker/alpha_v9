@extends('layouts.web')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/old/owl-carousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/old/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/style_home.css') }}">
@endsection

@section('content')

    @include('_partials.social')

    <div class="owl-carousel owl-theme custom-t">
        @foreach ($imagenes as $imagen)
            @if ($imagen->seccion == 'home_slider')           
                <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>              
            @endif
        @endforeach
        <a href="https://heyzine.com/flip-book/9ec0716f99.html" target="_blank" class="item"><img src="{{ asset('imgs/slider/8m.png') }}" alt="" class=""></a>
        <!--a href="{{ asset('catalogos/valentin_compress.pdf') }}" target="_blank" class="item"><img src="{{ asset('imgs/slider/san_valentin.jpg') }}" alt="" class=""></a-->
        <a href="#" data-toggle="modal" data-target="#videoAlpha" class="item"><img src="{{ asset('imgs/slider/viajes_2023.png') }}" alt="" class=""></a>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="videoAlpha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <video width="800" controls autoplay='autoplay' loop='true' style="margin-top: 80px;" muted>
                <source src="{{ asset('imgs/viajes_video.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>


    <div class="content" style="display: -webkit-box;">
        <div class="grid">
            <figure class="effect-lily">
                <img src="{{ asset('imgs/dynamic_items/sombreros.png') }}" alt="Sombreros"/> <!-- 480 * 360 tamaño de las imagenes -->
                <figcaption>
                    <div>
                        <!--h2>Catalogo <span>{{ now()->year }}</span></h2-->
                        <!--p>Lily likes to play with crayons and pencils</p-->
                    </div>
                    <a href="{{ url('https://www.alphapromos.mx/producto/sombrero-playa-sm-12') }}" target="_blank">Ver mas</a>
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
            @foreach ($imagenes as $imagen)
                @if ($imagen->seccion == 'catalogos')
                    <figure class="effect-lily">
                        <img src="{{ Storage::url($imagen->path) }}" alt="img12"/> <!-- 480 * 360 tamaño de las imagenes -->
                        <figcaption>
                            <div>
                                <h2>Catalogo <span>{{ $imagen->titulo }}</span></h2>
                                <!--p>Lily likes to play with crayons and pencils</p-->
                            </div>
                            <a href="{{ Storage::url($imagen->pdf) }}" target="_blank">View more</a>
                        </figcaption>     
                    </figure>
                @endif
            @endforeach
        </div>
    </div>

    <div class="features text-center">
        <div class="row mobile-row">
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
            items:2,
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



