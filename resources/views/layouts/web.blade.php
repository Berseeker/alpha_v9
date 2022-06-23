<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AlphaPromos') }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/home/index.css') }}">
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
    $('.search-global').keypress(function (e) {
    if (e.which == 13) {
        $('form#login').submit();
        return false;    //<---- Add this line
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
        window.location.href="/ver-cotizacion";
      }   
  });
  
});
function deleteCart(sdk)
{
  console.log(sdk);
}
</script>

@yield('page-scripts')
</html>
