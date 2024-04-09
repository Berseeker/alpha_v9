<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('imgs/logos/alpha.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AlphaPromos | @yield('title')</title>
    <meta name="author" content="Alpha Promos Promocionales">
    <meta property="og:site_name" content="Alpha Promos">
    <meta property="og:type" content="Article">
    <meta name="og:title" content="Inicio | Alpha Promos">
    <meta name="description" content="Alphapromos.mx ofrece productos promocionales en Cancún. Encuentra artículos promocionales, regalos corporativos, mercancía personalizada y más. ¡Destaca tu marca con nuestros productos de calidad en Cancún. Productos promocionales Cancún, Regalos corporativos Cancún, Merchandising con logotipo Cancún, Artículos promocionales Cancún." />
    <meta name="keywords" content="promocionales,regalos,publicidad,termos,libretas,relojes,boligrafos,mama,papa,dia del padre,dia de la madre,regreso a clases">
    <meta name="og:description" content="Artículos Promocionales">
    <meta property="og:image" content="https://www.alphapromos.mx/imgs/v3/logos/logo_alpha.png">
    <meta property="twitter:image" content="https://www.alphapromos.mx/imgs/v3/logos/logo_alpha.png">
    <!-- JQUERY 3.x -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <!-- COOKIE JS PLUGIN - -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
    <!-- CSS BOOTSTRAP V5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- CARROUSEL PLUGIN - https://owlcarousel2.github.io/OwlCarousel2 -->
    <link rel="stylesheet" href="{{ asset('css/v3/home/owl_carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/v3/home/owl_carousel/owl.theme.default.css') }}" />
    <script src="{{ asset('js/v3/owl_carousel/owl.carousel.min.js') }}"></script>
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/8d420a663d.js" crossorigin="anonymous"></script>
    <!-- GLOBAL CSS -->
    <link rel="stylesheet" href="{{ asset('css/v3/home/king_ediberto.css') }}">
    <!-- CUSTOM CSS FOR EACH PAGE -->
    @yield('page-styles')
    <!-- Chat en vivo -->
    <script src="//code-sa1.jivosite.com/widget/DuWHrZwtML" async></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-525GD06J3K"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-525GD06J3K');
  </script>
</head>
<body>
    <div id="app">
        @include('Home._partials.navbar')
        <div class="alert alert-warning" role="alert">
          <i class="fa-solid fa-triangle-exclamation"></i>
          Este producto ya se encuentra en el carrito!
        </div>
        <div class="alert alert-warning remove-cart-warning" role="alert">
          <i class="fa-solid fa-triangle-exclamation"></i>
          Producto eliminado!
        </div>
        <div class="alert alert-success" role="alert">
          <i class="fa-solid fa-cart-plus"></i>
          Producto agregado!
        </div>
        <main class="py-4">
            @yield('content')
        </main>
        @include('Home._partials.footer')
    </div>
</body>

<script type="text/javascript">

  // When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
  window.onscroll = function() {scrollFunction()};

  function scrollFunction() {
    if (document.body.scrollTop >= 60 || document.documentElement.scrollTop >= 60) {
      document.getElementById("logo-img").style.width = "120px";
    } else if(document.documentElement.scrollTop < 59) {
      document.getElementById("logo-img").style.width = "200px";
    } else {
      document.getElementById('logo-img').style.width = "200px";
    }
  }

  $(document).ready(function() {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    $( "#categoria-nav" ).hover(
      function() {
        if (!$( "#menu-alpha" ).hasClass( "menu-active" )) {
          $("#menu-alpha").addClass('menu-active');
        }
      }, function() {

      }
    );

    $( "#holder" ).hover(
      function() {

      }, function() {
        if ($( "#menu-alpha" ).hasClass( "menu-active" )) {
          $("#menu-alpha").removeClass('menu-active');
        }
      }
    );

    $( ".link-catalogo" ).hover(
      function() {
        console.log($(this).attr('data'));
        $("#img-menu").append( $( "<img src='" + $(this).attr('data') + "' />" ) );
      }, function() {
        $("#img-menu").find( "img" ).last().remove();
      }
    );

    $( "li.fade" ).hover(function() {
      $("#img-menu").fadeOut( 100 );
      $("#img-menu").fadeIn( 500 );
    });

    $( "#newsletter" ).submit(function( event ) {
      event.preventDefault();
      if( $("#news-email").val().length == 0 )
      {
        if( $('#email-news-error').hasClass('warning-not') ) {
          $("#email-news-error").removeClass('warning-not');
          $("#email-news-error").addClass('warning-visible');
          $("#errorMessageEmail").text('');
          $("#errorMessageEmail").text('Es necesario ingresar un email');
        }

      } else {
        if ( $('#email-news-error').hasClass('warning-visible') ) {
          $("#email-news-error").removeClass('warning-visible');
          $("#email-news-error").addClass('warning-not');
        }
        // AJAX
        $.ajax({
            type: $( "#newsletter" ).attr('method'),
            url: $( "#newsletter" ).attr('action'),
            data: $( "#newsletter" ).serialize(),
            success: function (data) {
              if (data.status == 'error') {
                $("#email-news-error").removeClass('warning-not');
                $("#email-news-error").addClass('warning-visible');
                $("#errorMessageEmail").text('');
                $("#errorMessageEmail").text(data.msg);
              } else {
                $("#email-news-success").removeClass('success-not');
                $("#email-news-success").addClass('success-visible');
                $("#successMessageEmail").text('');
                $("#successMessageEmail").text(data.msg);
              }
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
      }
    });

  });
</script>
<script type="text/javascript">
  //BUSCADOR
  /*document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('search-global');
    input.addEventListener('keyup', event => {
      console.log(event.target.value);
      $.ajax({
        url:"/api/search/" + event.target.value,
        method:"GET",
        dataType : "json",
        success:function(data)
        {
          var template = '';
          if (data.length == 0) {
            template = template + '<li><p style="text-align:center;"><i class="fa-brands fa-searchengin" style="margin-right:10px;"></i> Sin resultados..</p></li>';
            $('#searched-items').css('height','50px');
          } else {

            data.forEach(function(element, indice, array) {
              string = element.name + ' ' + element.code;
              //quitar acentos
              string = string
                        .normalize('NFD')
                        .replace(/([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi,"$1")
                        .normalize();
              string = string.replace(/\s+/g, "-");
              string = string.replace(/[^\w\-]+/g, "");
              string = string.replace(/\-\-+/g, "-");
              string = string.replace(/^-+/, "");
              string = string.replace(/-+$/, "");
              slug = string.replace(/\s+/g, '-');
              lower = string.toLowerCase();
              slug = lower.replace(/\s/g,'-');
              console.log(slug);
              img = "{{ asset('imgs/no_disp.png') }}";
              if(element.images != null){
                  var obj = jQuery.parseJSON(element.images);
                  console.log(obj);
                  if(obj[0].includes('http'))
                  {
                    img = obj[0];
                  }else{
                    img = '{{ asset("storage/doblevela/images") }}' +'/'+ obj[0];
                  }

              }
              template = template + '<li><a href="/producto/'+ slug +'"><p> <img src="'+img+'" style="width:50px;margin-right:10px;" />'+ element.name +'</p></a></li>';
            });
            $('#searched-items').css('height','200px');
          }
          $('#searched-items').html('');
          $('#searched-items').css('display','block');
          $('#searched-items').html(template);
        }
      });
    });
  });*/
  $('#search-global').keypress(function (e) {
    if (e.which == 13) {
      window.location.replace("/busqueda/" + $(this).val());
    }
  });
</script>
<script type="text/javascript">
$(document).ready(function(){
  if(Cookies.get('carrito_cotizaciones') != undefined)
  {
    //SE DEBE DE GUARDA EL SDK Y CADA QUE SE CONSULTE IR POR EL PRODUCTO A LA API Y MOSTRAR EN EL CARRITO
      var items = JSON.parse(Cookies.get('carrito_cotizaciones'));
      $('.items-hooked').html('');

      if (items.length === 0)
      {
        var template = '<li>Sin Productos!!</li>';
        $(".items-hooked").append(template);
      }else{
        //console.log(items);
        items.forEach(element => {

          $.ajax({
            url:"/api/producto/"+element,
            method:"GET",
            dataType : "json",
            success:function(data)
            {
                var template = '<li><img src="'+data.img+'" style="width:60px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</li>';
                $(".items-hooked").append(template);
            }
          });

        });
        var template = '<li><button class="btn empty-cart" onclick="emptyCart()"> <i class="fa-solid fa-trash-can" style="margin-right:10px;"></i> Vaciar cesta</button></li>';
        $(".items-hooked").append(template);
      }
      var cont = items.length;
      $("#cart-number").css('display','block');
      $("#cart-number").html('');
      $("#cart-number").html(cont);

  } else {
    console.log('cookie no definida');
  }

  // Cuando se agrega un producto al carrito
  $('.btn-cart').on('click', function (e) {
      var sdk = $(this).attr("sdk"),
      url = "{{ url('/')}}";
      console.log(sdk);
      if(!$(this).hasClass('btn-loaded'))
      {
        $.ajax({
            url:"/api/producto/"+sdk,
            method:"GET",
            dataType : "json",
            success:function(data)
            {
              //console.log(data);
              var items = [];
              if(Cookies.get('carrito_cotizaciones') == undefined)
              {
                  //console.log('Se inicializa el carrito de compras');
                  $('.items-hooked').html('');
                  var template = '<li><img src="'+data.img+'" style="width:60px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</li>';
                  $(".items-hooked").append(template);
                  template = '<li><button class="btn empty-cart" onclick="emptyCart()"> <i class="fa-solid fa-trash-can" style="margin-right:10px;"></i> Vaciar cesta</button></li>';
                  $(".items-hooked").append(template);
                  items.push(data.sdk);
                  $("#cart-number").css('display','block');
                  $("#cart-number").html('');
                  $("#cart-number").html('1');
                  var value = JSON.stringify(items);
                  Cookies.set('carrito_cotizaciones',value,{ expires: 2 });
                  $('.alert-success').css('display','inline-block');
                  $(".alert-success").fadeOut(5000);
              }
              else
              {
                var items = JSON.parse(Cookies.get('carrito_cotizaciones'));
                if(items.includes(sdk)){ // Ya existe este producto en el carrito
                    $('.alert-warning').css('display','inline-block');
                    $(".alert-warning").fadeOut(5000);
                }
                else {
                  $('.items-hooked').html('');
                  items.forEach(element => {

                    $.ajax({
                      url:"/api/producto/"+element,
                      method:"GET",
                      dataType : "json",
                      success:function(data)
                      {
                          var template = '<li><img src="'+data.img+'" style="width:60px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</li>';
                          $(".items-hooked").append(template);
                      }
                    });

                  });
                  var template = '<li><button class="btn empty-cart" onclick="emptyCart()"> <i class="fa-solid fa-trash-can" style="margin-right:10px;"></i> Vaciar cesta</button></li>';
                  $(".items-hooked").append(template);
                  template = '<li><img src="'+data.img+'" style="width:60px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</li>';
                  $(".items-hooked").append(template);


                  items.push(data.sdk);
                  var cont = items.length;
                  $("#cart-number").css('display','block');
                  $("#cart-number").html('');
                  $("#cart-number").html(cont);
                  var value = JSON.stringify(items);
                  Cookies.set('carrito_cotizaciones',value, { expires: 2 });
                  $('.alert-success').css('display','inline-block');
                  $(".alert-success").fadeOut(5000);
                }
              }
            }
        });
        $(this).addClass('btn-loaded');
      } else {
        $('.alert-warning').css('display','inline-block');
        $(".alert-warning").fadeOut(5000);
      }
  });
  // NOSE QUE HACE
  $('.btn-cart-add').on('click', function (e) {
      var sdk = $(this).attr("sdk"),
      url = "{{ url('/')}}";

      $.ajax({
          url:"/api/producto/"+sdk,
          method:"GET",
          dataType : "json",
          success:function(data)
          {
            //console.log(data);
            var items = [];
            if(Cookies.get('carrito_cotizaciones') == undefined)
            {
                //console.log('Se inicializa el carrito de compras');
                $('.items-hooked').html('');
                var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.name+'">'+data.name+'</a>';
                $(".items-hooked").append(template);
                items.push(data.code);
                $("#shop-cart").css('display','inline-flex');
                $(".contador-cart").html('');
                $(".contador-cart").html('1');
                var value = JSON.stringify(items);
                Cookies.set('carrito_cotizaciones',value, { expires: 2 });
            }
            else
            {
              var items = JSON.parse(Cookies.get('carrito_cotizaciones'));
              $('.items-hooked').html('');
              items.forEach(element => {

                $.ajax({
                  url:"/api/producto/"+element,
                  method:"GET",
                  dataType : "json",
                  success:function(data)
                  {
                      var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.name+'">'+data.name+'</a>';
                      $(".items-hooked").append(template);
                  }
                });

              });
              var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.name+'">'+data.name+'</a>';
              $(".items-hooked").append(template);

              items.push(data.code);
              var cont = items.length;
              $("#shop-cart").css('display','inline-flex');
              $(".contador-cart").html('');
              $(".contador-cart").html(cont);
              var value = JSON.stringify(items);
              Cookies.set('carrito_cotizaciones',value, { expires: 2 });
            }
            window.location.href="/ver-cotizacion";
          }
      });
  });

});
function emptyCart()
{
  Cookies.remove('carrito_cotizaciones');
  $('.items-hooked').html('');
  var template = '<li>Sin Productos!!</li>';
  $(".items-hooked").append(template);
  $("#cart-number").css('display','none');
  $("#cart-number").html('');
}
</script>
<!-- CUSTOM SCRIPTS FOR EACH PAGE-->
@yield('page-scripts')
</html>
