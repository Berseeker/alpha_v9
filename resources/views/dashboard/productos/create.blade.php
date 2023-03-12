@extends('layouts/contentLayoutMaster')

@section('title', 'Product')

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

    <!-- profile -->
    <div class="card">
      <div class="card-header border-bottom">
        <h4 class="card-title">Nuevo Producto</h4>
      </div>
      <div class="card-body py-2 my-25">

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
        <form class="validate-form mt-2 pt-50" method="POST" action="{{url("/dashboard/store-product")}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="name">Nombre</label>
              <input
                type="text"
                class="form-control"
                name="name"
                value="{{ old('name') ?? ''}}"
              />
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="code">SDK <small>(Identificador unico del producto)</small></label>
              <input
                type="text"
                class="form-control"
                name="code"
                value="{{ old('code') ?? '' }}"
              />
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="colors">Colores disponibles <small>(Si es mas de un color, separa con coma)</small></label>
                <input
                  type="text"
                  class="form-control"
                  name="colors"
                  value="{{ old('colors') ?? '' }}"
                />
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="images">Imagen(es) del producto</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="printing_area">Area de Impresión</label>
                <input
                  type="text"
                  class="form-control"
                  name="printing_area"
                  value="{{ old('printing_area') ?? ''}}"
                />
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="provider">Proveedor</label>
                <select name="provider" class="form-control">
                    <option value="AlphaPromos" selected>Alpha Promos</option>
                    <option value="Innova">Innova</option>
                    <option value="PromoOpcion">Promo Opcion</option>
                    <option value="DobleVela">Doble Vela</option>
                    <option value="Forpromotional">For Promotional</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="categoria">Categoria</label>
              <select id="categorias" class="select2 form-select" name="categoria">
                @foreach ($categorias as $categoria)                  
                        <option value="{{ $categoria->id }}"> {{ $categoria->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label for="subcategoria" class="form-label">Subcategoria</label>
              <select class="select2 form-select" id="sub-dynamic" name="subcategoria">
                
              </select>
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="printing_methods">Metodos de Impresion <small>(Si Son varios, separarlos con una coma)</small></label>
                <input
                  type="text"
                  class="form-control"
                  name="printing_methods"
                  value="{{ old('printing_methods') ?? '' }}"
                />
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="box_pieces">Nº de Pzas por caja</label>
                <input
                  type="number"
                  class="form-control"
                  name="box_pieces"
                  value="{{ old('box_pieces') ?? '' }}"
                />
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="material">Material del cual esta hecho</label>
                <input
                  type="text"
                  class="form-control"
                  name="material"
                  value="{{ old('material') ?? '' }}"
                />
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="details">Descripcion</label>
              <textarea class="form-control" name="details"></textarea>
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
