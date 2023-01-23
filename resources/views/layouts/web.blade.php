<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('imgs/logos/alpha.ico') }}">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AlphaPromos @yield('title')</title>
  <!-- JQUERY 3.x -->
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  <!-- COOKIE JS PLUGIN - -->
  <script type="module" src="{{ asset('js/old/js.cookie.js') }}"></script>
  <script nomodule defer src="{{ asset('js/old/js.cookie.js') }}"></script>
  <!-- CSS BOOTSTRAP V5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <!-- CARROUSEL PLUGIN - https://swiperjs.com -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
  <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
  <!-- FONT AWESOME -->
  <script src="https://kit.fontawesome.com/8d420a663d.js" crossorigin="anonymous"></script>
  <!-- GLOBAL CSS -->
  <link rel="stylesheet" href="{{ asset('css/v3/home/master_styles.css') }}">
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
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
      document.getElementById("logo-img").style.width = "120px";
    } else {
      document.getElementById("logo-img").style.width = "200px";
    }
  }

  $(document).ready(function() {

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
        $("#img-menu").append( $( "<img src='/imgs/v3/menu_navbar/" + $(this).attr('data') + ".jpeg' />" ) );
      }, function() {
        $("#img-menu").find( "img" ).last().remove();
      }
    );

    $( "li.fade" ).hover(function() {
      $("#img-menu").fadeOut( 100 );
      $("#img-menu").fadeIn( 500 );
    });

    $( "#newsletter" ).submit(function( event ) {
      console.log('acepto');
      console.log($("#news-email").val().length);
      event.preventDefault();
      if( $("#news-email").val().length == 0 )
      {
        if( $('#email-news-error').hasClass('warning-not') ) {
          $("#email-news-error").removeClass('warning-not');
          $("#email-news-error").addClass('warning-visible');
          $("#errorMessageEmail").text('');
          $("#errorMessageEmail").text('Es necesario ingresar un email');
          console.log('here');
        }
        
      } else {
        if ( $('#email-news-error').hasClass('warning-visible') ) {
          $("#email-news-error").removeClass('warning-visible');
          $("#email-news-error").addClass('warning-not');
        }
        // AJAX
      }

    });
 
  });
</script>
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('search-global');

    input.addEventListener('keyup', event => {
      $.ajax({
        url:"/api/search-productos/" + event.target.value,
        method:"GET",
        dataType : "json",
        success:function(data)
        {  
          var template = '';
          data.forEach(function(element, indice, array) {
            string = element.name + ' ' + element.codigo;
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
                if(obj[0].includes('http'))
                {
                  img = obj[0];
                }else{
                  img = '{{ asset("storage") }}' +'/'+ obj[0];                         
                }
                
            }
            template = template + '<li><a href="/producto/'+ slug +'"><p> <img src="'+img+'" style="width:50px;" />'+ element.name +'</p><span style="color:black;">'+ element.details +'</span></a></li>';
          });
          $('#searched-items').html('');
          $('#searched-items').css('display','block');
          $('#searched-items').html(template);
          //var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</a>';
            //$(".items-hooked").append(template);
        }
      });
    });
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
        var template = '<p class="text-warning" style="text-align:center;margin-top:20px;margin-bottom:20px;">No hay Productos!!</p>';
        $(".items-hooked").append(template);  
      }else{
    
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
      }
      var cont = items.length;
      $("#shop-cart").css('display','inline-flex');
      $(".contador-cart").html('');
      $(".contador-cart").html(cont);
      //console.log(test);
      
  }

  $('.btn-cart').on('click', function (e) {
      var sdk = $(this).attr("sdk"),
      url = "{{ url('/')}}";
      if(!$(this).hasClass('btn-loaded'))
      {
        $.ajax({
            url:"/api/producto/"+sdk,
            method:"GET",
            dataType : "json",
            success:function(data)
            {  
              console.log(data);
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
                  Cookies.set('carrito_cotizaciones',value);
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
                        var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</a>';
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
                Cookies.set('carrito_cotizaciones',value);
              }   
            }
        });
      }   
  });

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
                Cookies.set('carrito_cotizaciones',value);
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
              Cookies.set('carrito_cotizaciones',value);
            }
            window.location.href="/ver-cotizacion";   
          }
      });
  });
  
});
function deleteCart(sdk)
{
  console.log(sdk);
}
</script>
<!-- CUSTOM SCRIPTS FOR EACH PAGE-->
@yield('page-scripts')
</html>
