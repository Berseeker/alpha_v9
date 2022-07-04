@extends('layouts/contentLayoutMaster')

@section('title', 'Account')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel='stylesheet' href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
  <link rel='stylesheet' href="{{ asset('vendors/css/animate/animate.min.css') }}">
  <link rel='stylesheet' href="{{ asset('vendors/css/extensions/sweetalert2.min.css') }}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-sweet-alerts.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <ul class="nav nav-pills mb-2">
      <!-- Account -->
      <li class="nav-item">
        <a class="nav-link active" href="{{asset('page/account-settings-account')}}">
          <i data-feather="user" class="font-medium-3 me-50"></i>
          <span class="fw-bold">Account</span>
        </a>
      </li>
      <!-- security -->
      <li class="nav-item">
        <a class="nav-link" href="{{asset('page/account-settings-security')}}">
          <i data-feather="lock" class="font-medium-3 me-50"></i>
          <span class="fw-bold">Security</span>
        </a>
      </li>
      <!-- billing and plans -->
      <li class="nav-item">
        <a class="nav-link" href="{{asset('page/account-settings-billing')}}">
          <i data-feather="bookmark" class="font-medium-3 me-50"></i>
          <span class="fw-bold">Billings &amp; Plans</span>
        </a>
      </li>
      <!-- notification -->
      <li class="nav-item">
        <a class="nav-link" href="{{asset('page/account-settings-notifications')}}">
          <i data-feather="bell" class="font-medium-3 me-50"></i>
          <span class="fw-bold">Notifications</span>
        </a>
      </li>
      <!-- connection -->
      <li class="nav-item">
        <a class="nav-link" href="{{asset('page/account-settings-connections')}}">
          <i data-feather="link" class="font-medium-3 me-50"></i>
          <span class="fw-bold">Connections</span>
        </a>
      </li>
    </ul>

    <!-- profile -->
    <div class="card">
      <div class="card-header border-bottom">
        <h4 class="card-title">Nuevo Producto</h4>
      </div>
      <div class="card-body py-2 my-25">
        <!-- header section -->
        <div class="d-flex">
          <!-- upload and reset button -->
          <div class="d-flex align-items-end mt-75 ms-1">
            <div>
              <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75">Proveedor</label>
              <button type="button" id="account-reset" class="btn btn-sm btn-outline-secondary mb-75"></button>
              <p class="mb-0 text-red">Grandes poderes conllevan una gran responsabilidad</p>
              <p class="mb-0">Edite bajo su propio riesgo!</p>
            </div>
          </div>
          <!--/ upload and reset button -->
        </div>
        <!--/ header section -->

        @if($errors->any())
            <div class="alert alert-danger " >
                <ul style="list-style: none;">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="bg-success" style="padding:10px;margin-bottom:30px;text-align:center;border-radius:5px;color:white;">
                <p style="margin-bottom: 0px;"><i class="fas fa-thumbs-up" style="margin-right: 10px;"></i> {{ session('success') }}</p>
            </div>
        @endif 
        @if (session('warning'))
            <div class="bg-warning" style="padding:10px;margin-bottom:30px;border-radius: 5px;color:white;text-align:center;">
                <p style="margin-bottom: 0px;"><i class="fas fa-exclamation" style="margin-right: 10px;"></i> {{ session('warning') }}</p>
            </div>
        @endif
        <!-- form -->
        <form class="validate-form mt-2 pt-50" method="POST" action="{{url("/dashboard/create-product")}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="SDK">Nombre</label>
              <input
                type="text"
                class="form-control"
                id="nickname"
                name="nombre"
                placeholder="Nombre del producto"
              />
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="accountEmail">Modelo del producto</label>
              <input
                type="text"
                class="form-control"
                id="accountEmail"
                name="modelo"
                placeholder="Modelo del producto"
              />
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="accountEmail">SDK</label>
                <input
                  type="text"
                  class="form-control"
                  id="accountEmail"
                  name="SDK"
                  placeholder="SDK"
                />
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="accountEmail">Imagen del producto</label>
                <input type="file" name="nueva_imagen[]" id="fileToUpload" class="form-control" multiple>
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="accountEmail">Color(Si Son varios colores, seprarlos con una coma)</label>
                <input
                  type="text"
                  class="form-control"
                  id="accountEmail"
                  name="color"
                  placeholder="Azul"
                />
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="accountEmail">Proveedor</label>
                <select name="proveedor" class="form-control">
                    <option value="Innova">Innova</option>
                    <option value="PromoOpcion">Promo Opcion</option>
                    <option value="Doble Vela">Doble Vela</option>
                    <option value="Forpromotional">For Promotional</option>
                    <option value="AlphaPromos">Alpha Promos</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="accountEmail">Metodos de Impresion(Si Son varios, seprarlos con una coma)</label>
                <input
                  type="text"
                  class="form-control"
                  id="accountEmail"
                  name="metodo_impresion"
                  placeholder="Impresion"
                />
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="country">Categorias</label>
              <select id="categorias" class="select2 form-select" name="categoria">
                @foreach ($categorias as $categoria)                  
                        <option value="{{ $categoria->id }}"> {{ $categoria->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label for="language" class="form-label">Subcategorias</label>
              <select class="select2 form-select" id="sub-dynamic" name="subcategoria">
                
              </select>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="accountEmail">Descripcion</label>
              <textarea 
                class="form-control" 
                name="descripcion">          
              </textarea>
            </div>           
            <div class="col-12">
              <button type="submit" class="btn btn-primary mt-1 me-1">Crear</button>
              <a type="reset" class="btn btn-outline-secondary mt-1" href="{{url("/dashboard/productos") }}">Cancelar</a>
            </div>
          </div>
        </form>
        <!--/ form -->
      </div>
    </div>
  </div>
</div>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/cleave/cleave.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset('js/scripts/pages/page-account-settings-account.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      var url = '{{ url("/")}}';
     //AL INICIO CUANDO NO TIENE NADA, SE EJECUTA ESTA PARTE
        $.get(url +"/api/get-subcategorias/" + $('#categorias').val(), function(data, status){
            var subcategorias = JSON.parse(data);
            $('#sub-dynamic').html('');
            var template = '';
            subcategorias.forEach(subcategoria => {
                //console.log(subcategoria);
                
                template = template + '<option value="'+subcategoria.id+'">'+subcategoria.nombre+'</option>';
            });
            $('#sub-dynamic').html(template);
        });
    //FIN DE CUANDO NO TIENE NADA
      //console.log(url);
      $('#categorias').on('change', function() {
        //console.log( this.value ); VER EL ID QUE SE ESTABA SELECCIONANDO
    //CUANDO YA SE DIO UN CLICK, CUANDO SE CAMBIA DE CATEGORIA, HACE ESTA PARTE
        $.get(url +"/api/get-subcategorias/" + this.value, function(data, status){
          var subcategorias = JSON.parse(data);
          $('#sub-dynamic').html('');
          var template = '';
          subcategorias.forEach(subcategoria => {
              //console.log(subcategoria);
             
              template = template + '<option value="'+subcategoria.id+'">'+subcategoria.nombre+'</option>';
          });
          $('#sub-dynamic').html(template);
        });
    //FIN DE CUANDO DA CLIK, O CAMBIA LA CATEGORIA
      });
    });
    
  </script>
@endsection
