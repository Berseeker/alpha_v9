<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('imgs/logos/alpha.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'AlphaPromos') }}</title>-->

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/home/index_master.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/items.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fonts/feather/iconfont.css') }}">
    <script src="https://kit.fontawesome.com/8d420a663d.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/old/js.cookie.js') }}" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('css/home/home_smart.css') }}">
    

    @yield('page-styles')
  <script src="//code-sa1.jivosite.com/widget/DuWHrZwtML" async></script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-525GD06J3K"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-525GD06J3K');
  </script>

  {!! SEOMeta::generate() !!}
  {!! OpenGraph::generate() !!}
  {!! Twitter::generate() !!}
  {!! JsonLd::generate() !!}

</head>
<body class="pace-done vertical-layout vertical-menu-modern content-detached-left-sidebar navbar-floating footer-static menu-expanded">
    <div id="app">
       @include('menu.index')

        <main class="py-4">
            @yield('content')
        </main>

        @include('_partials.footer')
    </div>
</body>
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
            string = element.nombre + ' ' + element.modelo;
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
            template = template + '<li><a href="/producto/'+ slug +'"><p> <img src="'+img+'" style="width:50px;" />'+ element.nombre +'</p><span style="color:black;">'+ element.descripcion +'</span></a></li>';
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
                var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</a>';
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
      console.log(sdk);
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
                  var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</a>';
                  $(".items-hooked").append(template);
                  items.push(data.sdk);
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
                var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</a>';
                $(".items-hooked").append(template);

                items.push(data.sdk);
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
                var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</a>';
                $(".items-hooked").append(template);
                items.push(data.sdk);
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
              var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</a>';
              $(".items-hooked").append(template);

              items.push(data.sdk);
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

@yield('page-scripts')
</html>
