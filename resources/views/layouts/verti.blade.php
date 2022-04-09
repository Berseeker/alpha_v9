<body class="vertical-layout vertical-menu-modern {{ $configData['verticalMenuNavbarType'] }} {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['sidebarClass']}} {{ $configData['footerType'] }} {{$configData['contentLayout']}}"
data-open="click"
data-menu="vertical-menu-modern"
data-col="{{$configData['showMenu'] ? $configData['contentLayout'] : '1-column' }}"
data-framework="laravel"
data-asset-path="{{ asset('/')}}">
  <!-- BEGIN: Header-->
  @include('panels.nav')
  <!-- END: Header-->

  <!-- BEGIN: Main Menu-->

  <!-- END: Main Menu-->

  <!-- BEGIN: Content-->
  <div class="app-content content {{ $configData['pageClass'] }}">
    <!-- BEGIN: Header-->
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

    @if(($configData['contentLayout']!=='default') && isset($configData['contentLayout']))
    <div class="content-area-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
      <div class="{{ $configData['sidebarPositionClass'] }}">
        <div class="sidebar">
          {{-- Include Sidebar Content --}}
          @yield('content-sidebar')
        </div>
      </div>
      <div class="{{ $configData['contentsidebarClass'] }}">
        <div class="content-wrapper">
          <div class="content-body">
            {{-- Include Page Content --}}
            @yield('content')
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
      {{-- Include Breadcrumb --}}
      
        @include('panels.breadcrumb')
      

        <div class="content-body">
            {{-- Include Page Content --}}
            @yield('content')
        </div>
    </div>
    @endif

  </div>
  <!-- End: Content-->

  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  {{-- include footer --}}
  @include('panels/footer')

  {{-- include default scripts --}}
  @include('panels/scripts')

  <script type="text/javascript">
    $(window).on('load', function() {
      if (feather) {
        feather.replace({
          width: 14, height: 14
        });
      }
    })
  </script>
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
  
});
function deleteCart(sdk)
{
  console.log(sdk);
}
</script>
</body>
</html>
