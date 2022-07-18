@extends('layouts/contentLayoutMaster')

@section('title', 'Subiendo Imagenes')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset('css/old/pickadate.css') }}">
        <script src="{{ asset('js/old/jquery.min.js')}}"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection

@section('content')

<section id="basic-vertical-layouts">
  <div class="row match-height">
    <div class="offset-md-3 col-md-6 col-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fas fa-pencil-alt" style="font-size: 30px;color: orange;margin-right: 10px;"></i>Subiendo Imagenes</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
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
              <form class="form form-vertical" id='uploadImages' enctype="multipart/form-data" method="POST" action="{{ url('/dashboard/create-image') }}">
                @csrf
                <div class="form-body">
                    <div  class="form-group" style="margin-top:10px;">
                        <label for="">Sección</label>
                        <select name="secciones" id ='secciones' class="form-control">
                            <option value="home_slider">Home Slider</option>
                            <option value="catalogos">Catalogos</option>
                            <option value="displays">Displays</option>
                        </select>
                    </div>
                    <div  class="form-group" style="margin-top:10px;">
                        <label for="fileToUpload">Imagen:</label>
                        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                    </div>
                    
                    <div id="atributos-dinamicos"></div>
                    
                    <div  class="form-group" style="margin-top:10px;">  
                        <button type="submit" class="btn btn-primary" style="margin-top:25px;">Subir Imagen</button>
                    </div>
                </div><!-- End form-body-->
              </form>
            </div><!-- End card-body-->
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset('vendors/js/pickers/pickadate/picker.js') }}"></script>
        <script src="{{ asset('vendors/js/pickers/pickadate/picker.date.js') }}"></script>
        <script src="{{ asset('vendors/js/pickers/pickadate/picker.time.js') }}"></script>
        <script src="{{ asset('vendors/js/pickers/pickadate/legacy.js') }}"></script>
        <script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('js/scripts/forms/pickers/form-pickers.js') }}"></script>
        <script type="text/javascript">
            const select = document.getElementById('secciones');

            select.addEventListener('change', function handleChange(event) {
                //console.log(event.target.value); // 👉️ get selected VALUE
                if(event.target.value == 'catalogos'){
                    $('#atributos-dinamicos').html('');
                    $template = '<div class="form-group" style="margin-top:10px;"><label> Titulo del Catalogo:</label> <input name="titulo" type="test" class="form-control" /></div>' +
                    '<div class="form-group" style="margin-top:10px;"><label> Descripcion del catalogo:</label> <input type="text" name="parrafo" class="form-control" /> </div>' +
                    '<div class="form-group" style="margin-top:10px;"><label> Catalogo (PDF):</label> <input type="file" name="pdf" class="form-control"> </div>';
                    $('#atributos-dinamicos').html($template);
                }else {
                    $('#atributos-dinamicos').html('');
                }
            });
        </script>
@endsection
