@php
  $configData = Helper::applClasses();
@endphp
@extends('layouts/home')

@section('title', 'AlphaPromos')

@section('vendor-style')
        <link rel="stylesheet" href="{{ asset('css/home/stack_motion/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home/stack_motion/grid.css') }}">
        <script src="{{asset('js/home/jquery_view.js')}}"></script>
        <script src="{{asset('js/home/stack_motion/main.js')}}"></script>
        <!--   Estilos Draggable --> 
        <link rel="stylesheet" href="https://use.typekit.net/ugp0unb.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/home/draggable/dragg.css') }}" />

@endsection

@section('content')

  @include('panels.home-draggable')

  <div class="gallery_wrapper">
    <div class="gallery_alpha">
      <a href="#" class="mySlide"><img src="{{ asset('img/boxSlider/refresh_alpha.png') }}" /></a>
      <a href="{{ url('/subcategoria/5') }}" class="mySlide"><img src="{{ asset('img/boxSlider/promo.png') }}" /></a>
      <a href="{{ url('/categoria/6') }}" class="mySlide"><img src="{{ asset('img/boxSlider/rain.png') }}" /></a>
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
          <p>Entrega de 24-48 horas.</p>
        </div>
      </div>
    </div>
  </div>

  <h1 class="title-home">Articulos Nuevos Línea 2021</h1>
  <div class="divider-custom" style="color: #AADD35;">
      <div class="divider-custom-line"></div>
      <div class="divider-custom-icon">
          <img src="{{ asset('img/logos/alpha_icon.png') }}" alt="" class="alpha_icon">
      </div>
      <div class="divider-custom-line"></div>
  </div>

  <div class="features text-center">
    <div class="row">
      <div class="col-12 col-md-4 col-lg-4 offset-md-2 offset-lg-2 toAnimate">
        <div class="info">
          <a href="{{ asset('catalogos/tequila_circulo.pdf') }}" target="_blank">
            <div class="icon icon-info">
              <img src="{{ asset('img/logos/tequila_circulo.png')}}" alt="Tequila Circulo" style="width: 120px;">
            </div>
            <h4 class="info-title">Tequila Circulo Ultra Premium </h4>
          </a>
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-4  toAnimate">
        <div class="info">
          <a href="{{ asset('catalogos/prevencion.pdf') }}" target="_blank">
            <div class="icon icon-rose">
              <img src="{{ asset('img/logos/mask.jpg')}}" alt="Articulos de Prevencion" style="width: 100px;">
            </div>
            <h4 class="info-title">Artículos de Contingencia</h4>
          </a>        
        </div>
      </div>
      <!--div class="col-12 col-md-4 col-lg-4 offset-md-2 offset-lg-2 toAnimate">
        <div class="info">
          <a href="{{ asset('catalogos/dia_del_padre.pdf') }}" target="_blank">
            <div class="icon icon-info">
              <img src="{{ asset('img/logos/father.jpeg')}}" alt="Día de la Mujer" style="width: 200px;">
            </div>
            <h4 class="info-title">Día del Padre </h4>
          </a>
        </div-->
      </div>
      <!--div class="col-md-3 col-lg-3 toAnimate">
        <div class="info">
          <a href="{{ asset('catalogos/dia_x_kids.pdf') }}" target="_blank">
            <div class="icon icon-info">
              <img src="{{ asset('img/logos/childrens.jpg')}}" alt="Día del niño" style="width: 200px;">
            </div>
            <h4 class="info-title">Día de la niña/niño </h4>
          </a>
        </div>
      </div-->
      
    </div>
  </div>

  <h1 class="title-home">El artículo promocional by Alpha Promos</h1>
  <div class="divider-custom" style="color: #AADD35;">
      <div class="divider-custom-line"></div>
      <div class="divider-custom-icon">
          <img src="{{ asset('img/logos/alpha_icon.png') }}" alt="" class="alpha_icon">
      </div>
      <div class="divider-custom-line"></div>
  </div>
  <div class="container box-us">
    <p>El artículo promocional te acompaña siempre, en tu hogar, oficina, automóvil, de viaje, en todo momento y lugar; es útil, atractivo y económico. En Alpha Promos nos dedicamos a resolver tus necesidades de artículos promocionales y de hotelería en todas las áreas comerciales de tu empresa.
    Contamos con una  amplia gama de artículos importados y de producción nacional que abarcan desde una libreta, agendas de oficina, hasta escenografías y displays, productos propios (mochilas, bolsas, hieleras, canguros, porta gafetes magnéticos, bolsas de lavandería) entre muchos otros.
    Si no encuentra lo que necesita en nuestra página web, se lo localizamos y cotizamos.</p>
  </div>


<ul class="socialMedia">
  <li>
    <a href="https://wa.me/+5219981098156" target="_blank" class="whatsapp" id="whatsapp-social">
      <i class="fab fa-whatsapp"></i>
    </a>
  </li>
  <li>
    <a href="https://www.facebook.com/alphapromos.mx/" target="_blank" class="facebook" id="facebook-social">
      <i class="fab fa-facebook"></i>
    </a>
    </li>
</ul>

  <h1 class="title-home">Productos Destacados</h1>
  <div class="divider-custom" style="color: #AADD35;">
      <div class="divider-custom-line"></div>
      <div class="divider-custom-icon">
          <img src="{{ asset('img/logos/alpha_icon.png') }}" alt="" class="alpha_icon">
      </div>
      <div class="divider-custom-line"></div>
  </div>
  <div class="container">
    <div class="row grid grid--effect-altair">
      @foreach ($productos_destacados as $destacado)
      
          <a href="{{ url('/producto/'.Str::slug($destacado->nombre.' '.$destacado->modelo,'-')) }}" class="col-6 col-sm-3 grid__item grid__item--c2">
						<div class="stack">
							<div class="stack__deco"></div>
							<div class="stack__deco"></div>
							<div class="stack__deco"></div>
							<div class="stack__deco"></div>
							<div class="stack__figure">
                @php
                    $img = json_decode($destacado->images);
                @endphp
								<img class="stack__img" src="{{ $img[0] }}" alt="Image"/>
							</div>
						</div>
						<div class="grid__item-caption">
              <h3 class="grid__item-title">{{ $destacado->nombre }}</h3>
              <div class="description">
                <!--p>{{ $destacado->descripcion }}</p-->
              </div>
							
						</div>
          </a>
      @endforeach
    </div>
  </div>
                                              
@endsection


@section('page-script')
    <!-- Scripts Draggable -->
    <script src="{{ asset('js/home/draggable/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/home/draggable/TweenMax.min.js') }}"></script>
    <script src="{{ asset('js/home/draggable/draggabilly.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/home/draggable/demos.js') }}"></script>

    <!-- Scripts 3DSlider -->
    <script src="{{ asset('js/home/3dSlider/main.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
     
        $(".gallery_alpha").jR3DCarousel({
            "slideClass": 'mySlide',
            "width": 550,
            "height": 280,
            "slideLayout": "fill",
            "animation": "scroll3D",
            "animationCurve": "ease",
            "animationDuration": 1200,
            "animationInterval": 2000,
            "autoplay": true,
            "rotationDirection": "rtl",
            "navigation": "squares",
            
        });
        /*$('.jR3DCarouselGallery').jR3DCarousel({
							slideClass: 'mySlide',
						});*/
     
    </script>
    

    <script type="text/javascript">
      // Preload all the images in the page
      imagesLoaded(document.querySelectorAll('.img-inner'), {background: true}, () => document.body.classList.remove('loading'));
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
          var $slider = $('.slider');
          var $slickTrack = $('.slick-track');
          var $slickCurrent = $('.slick-current');
          var slideDuration = 900;

          //RESET ANIMATIONS
          // On init slide change
          $slider.on('init', function(slick){
            TweenMax.to($('.slick-track'), 0.9, {
              marginLeft: 0
            });
            TweenMax.to($('.slick-active'), 0.9, {
              x: 0,
              zIndex: 2
            });
          });
          // On before slide change
          $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide){
            TweenMax.to($('.slick-track'), 0.9, {
              marginLeft: 0
            });
            TweenMax.to($('.slick-active'), 0.9, {
              x: 0
            });
          });
          // On after slide change
          $slider.on('afterChange', function(event, slick, currentSlide){
            TweenMax.to($('.slick-track'), 0.9, {
              marginLeft: 0
            });
            $('.slick-slide').css('z-index','1');
            TweenMax.to($('.slick-active'), 0.9, {
              x: 0,
              zIndex: 2
            });
          });

          //SLICK INIT
          $slider.slick({
            speed: slideDuration,
            dots: true,
            waitForAnimate: true,
            useTransform: true,
            cssEase: 'cubic-bezier(0.455, 0.030, 0.130, 1.000)'
          })


            //PREV
            $('.slick-prev').on('mouseenter', function(){
                TweenMax.to($('.slick-track'), 0.6, {
                  marginLeft: "180px",
                  ease: Quad.easeOut
                });
                TweenMax.to($('.slick-current'), 0.6, {
                  x: -100,
                  ease: Quad.easeOut
                });
            });

            $('.slick-prev').on('mouseleave', function(){
                TweenMax.to($('.slick-track'), 0.4, {
                  marginLeft: 0,
                  ease: Sine.easeInOut
                });
                TweenMax.to($('.slick-current'), 0.4, {
                  x: 0,
                  ease: Sine.easeInOut
                });
            });

            //NEXT
                  $('.slick-next').on('mouseenter', function(){
      
                    TweenMax.to($('.slick-track'), 0.6, {
                      marginLeft: "-180px",
                      ease: Quad.easeOut
                    });
                    TweenMax.to($('.slick-current'), 0.6, {
                      x: 100,
                      ease: Quad.easeOut
                    });
                });

                $('.slick-next').on('mouseleave', function(){
                    TweenMax.to($('.slick-track'), 0.4, {
                      marginLeft: 0,
                      ease: Quad.easeInOut
                    });
                    TweenMax.to($('.slick-current'), 0.4, {
                      x: 0,
                      ease: Quad.easeInOut
                    });
                });  
              
                $( "#whatsapp-social" ).hover(
                  function() {
                    $( this ).addClass( "animate__animated" );
                    $( this ).addClass( "animate__rubberBand" );
                  }, function() {
                    $( this ).removeClass( "animate__animated" );
                    $( this ).removeClass( "animate__rubberBand" );
                  }
                );
                $( "#facebook-social" ).hover(
                  function() {
                    $( this ).addClass( "animate__animated" );
                    $( this ).addClass( "animate__rubberBand" );
                  }, function() {
                    $( this ).removeClass( "animate__animated" );
                    $( this ).removeClass( "animate__rubberBand" );
                  }
                );

      });

      function checkVisability() {
        $('.toAnimate').each(function(){
          if ($(this).inView("topOnly")) {
            //$(this).css("display",'block');
            $(this).addClass("animate__animated");
            $(this).addClass("animate__lightSpeedInLeft");
          }else {
            //$(this).css("display",'none');
            $(this).removeClass("animate__animated");
            $(this).removeClass("animate__lightSpeedInLeft");
          }
        });
      }
      checkVisability();
      // bind to window scroll event
      $(window).scroll(function() {
        checkVisability();
      });
    </script>
    <script type="text/javascript">
        (function() {

          [].slice.call(document.querySelectorAll('.grid--effect-altair > .grid__item')).forEach(function(stackEl) {
            new AltairFx(stackEl);
          });
        })();
    </script>
@endsection

