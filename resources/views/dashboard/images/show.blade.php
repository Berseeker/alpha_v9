@extends('layouts/contentLayoutMaster')

@section('title', 'Editando Imagenes')

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
            <h4 class="card-title"><i class="fas fa-pencil-alt" style="font-size: 30px;color: orange;margin-right: 10px;"></i>Imagenes</h4>
            <a href="{{ route('create.image') }}" class="btn btn-info">Subir Imagenes</a>
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

                <label for="">Sección</label>
                <select name="secciones" id ='secciones'>
                    <option value="home_slider">Home Slider</option>
                    <option value="catalogos">Catalogos</option>
                    <option value="displays">Displays</option>
                </select>

                <div id="atributos-dinamicos"></div>


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

            $(document).ready(function(){
                imprimir($('#secciones').val());
            });
   
            select.addEventListener('change', function handleChange(event) {
                //console.log(event.target.value); // 👉️ get selected VALUE
                imprimir($('#secciones').val());            
            });

            function imprimir(value)
            {
                switch(value){
                    case 'home_slider':
                        
                            $('#atributos-dinamicos').html('');
                            $template = '@if($images->isEmpty())' +
                            '<p style="text-align:center;margin-top:30px;"> No hay imagenes disponibles por ahora</p>' +
                            '@else' +
                            '@foreach ($images as $imagen)' +
                            '@if ($imagen->seccion == "home_slider")' +
                            '<form action="{{ url("/dashboard/update-image/".$imagen->id) }}" enctype="multipart/form-data" method="POST" style="margin-top:15px;">' +
                                    '@csrf' +                       
                                    '<div class="row" style="margin-top:10px;">' +
                                        '@if($imagen->pdf != null)'+  
                                        '<div class="col-sm-6">' +
                                            '<a target="_blank" class="form-control" href="{{ Storage::url($imagen->pdf) }}">Catalogo Actual</a>' +
                                        '</div>' +
                                        '@endif' +
                                        '<div class="col-sm-6">' +
                                            '<label class="form-control">Imagen Actual:</label>' +
                                            '<img src="{{ Storage::url($imagen->path) }}" alt="perros" style="width: 200px;margin-top:15px;">' +                                            
                                        '</div>' +
                                    '</div>' +                             
                                    '<div class="row" style="margin-top:25px;">' +
                                        '<div class="col-sm-6">' +
                                            '<div class="form-group"><label> Nuevo Catalogo (PDF):</label> <input type="file" name="nuevo_pdf" class="form-control"> </div>' +
                                        '</div>' +
                                        '<div class="col-sm-6">' +
                                            '<div class="form-group"><label> Nuevo Imagen </label> <input type="file" name="nueva_imagen" class="form-control"> </div>' +
                                            
                                        '</div>' +
                                    '</div>' +

                                    '<div class="form-group" style="margin-top:25px;">' +
                                        '<div class="row">' +
                                            '<div class="col-sm-6">' +
                                                '<div class="form-group"><button type="submit" class="btn btn-primary">Editar</button></div>' +
                                            '</div>' +
                                            '<div class="col-sm-6">' +
                                                '<a href="{{ url("dashboard/delete-images/".$imagen->id) }}" class="btn btn-danger">Eliminar</a> ' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                            '</form>' +
                            '@endif' +
                            '@endforeach' +
                            '@endif';
                            $('#atributos-dinamicos').html($template);
                        
                    break

                    case 'catalogos':
                        
                            $('#atributos-dinamicos').html('');
                            $template = '@if($images->isEmpty())' +
                            '<p style="text-align:center;margin-top:30px;"> No hay imagenes disponibles por ahora</p>' +
                            '@else' +
                            '@foreach ($images as $imagen)' +
                            '@if ($imagen->seccion == "catalogos")' +
                                '<form action="{{ url("/dashboard/update-image/".$imagen->id) }}" enctype="multipart/form-data" method="POST" style="margin-top:15px;">' +
                                    '@csrf' +
                                    '<div class="form-group" style="margin-top:10px;"><label> Titulo del Catalogo:</label> <input name="titulo" type="test" class="form-control" value="{{ $imagen->titulo }}" /></div>' +
                                    '<div class="form-group" style="margin-top:10px;"><label> Descripcion del catalogo:</label> <input type="text" name="parrafo" class="form-control"  value="{{ $imagen->parrafo }}" /> </div>' +
                                    '<div class="row" style="margin-top:15px;">' +
                                        '<div class="col-sm-6">' +
                                            '<a target="_blank" class="form-control" href="{{ Storage::url($imagen->pdf) }}">Catalogo Actual</a>' +
                                        '</div>' +
                                        '<div class="col-sm-6">' +
                                            '<label class="form-control">Imagen Actual:</label>' +
                                            '<img src="{{ Storage::url($imagen->path) }}" alt="perros" style="width: 200px;">' +
                                            
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row" style="margin-top:15px;">' +
                                        '<div class="col-sm-6">' +
                                            '<div class="form-group" style="margin-top:10px;"><label> Nuevo Catalogo (PDF):</label> <input type="file" name="nuevo_pdf" class="form-control"> </div>' +
                                        '</div>' +
                                        '<div class="col-sm-6">' +
                                            '<div class="form-group" style="margin-top:10px;"><label> Nuevo Imagen </label> <input type="file" name="nueva_imagen" class="form-control"> </div>' +
                                            
                                        '</div>' +
                                    '</div>' +
                                    '<div class="form-group" style="margin-top:10px;">' +
                                        '<div class="row">' +
                                            '<div class="col-sm-6">' +
                                                '<div class="form-group" style="margin-top:10px;"><button type="submit" class="btn btn-primary">Editar</button></div>' +
                                            '</div>' +
                                            '<div class="col-sm-6">' +
                                                '<a href="{{ url("dashboard/delete-images/".$imagen->id) }}" class="btn btn-danger">Eliminar</a> ' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</form>' +
                            '@endif @endforeach' +
                            '@endif';
                            $('#atributos-dinamicos').html($template);
                       
                    break

                    case 'displays':
                            $('#atributos-dinamicos').html('');
                            $template = '@if($images->isEmpty())' +
                            '<p style="text-align:center;margin-top:30px;"> No hay imagenes disponibles por ahora</p>' +
                            '@else' +
                            '@foreach ($images as $imagen)' +
                            '@if ($imagen->seccion == "displays")' +
                                '<form action="{{ url("/dashboard/update-image/".$imagen->id) }}" enctype="multipart/form-data" method="POST" style="margin-top:15px;">' +
                                    '@csrf' +
                                    '<div class="form-group" style="margin-top:10px;"><label> Titulo del Catalogo:</label> <input name="titulo" type="test" class="form-control" value="{{ $imagen->titulo }}" /></div>' +
                                    '<div class="form-group" style="margin-top:10px;"><label> Descripcion del catalogo:</label> <input type="text" name="parrafo" class="form-control"  value="{{ $imagen->parrafo }}" /> </div>' +
                                    '<div class="row" style="margin-top:15px;">' +
                                        '<div class="col-sm-6">' +
                                            '<a target="_blank" class="form-control" href="{{ Storage::url($imagen->pdf) }}">Catalogo Actual</a>' +
                                        '</div>' +
                                        '<div class="col-sm-6">' +
                                            '<label class="form-control">Imagen Actual:</label>' +
                                            '<img src="{{ Storage::url($imagen->path) }}" alt="perros" style="width: 200px;">' +
                                            
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row" style="margin-top:15px;">' +
                                        '<div class="col-sm-6">' +
                                            '<div class="form-group" style="margin-top:10px;"><label> Nuevo Catalogo (PDF):</label> <input type="file" name="nuevo_pdf" class="form-control"> </div>' +
                                        '</div>' +
                                        '<div class="col-sm-6">' +
                                            '<div class="form-group" style="margin-top:10px;"><label> Nuevo Imagen </label> <input type="file" name="nueva_imagen" class="form-control"> </div>' +
                                            
                                        '</div>' +
                                    '</div>' +
                                    '<div class="form-group" style="margin-top:10px;">' +
                                        '<div class="row">' +
                                            '<div class="col-sm-6">' +
                                                '<div class="form-group" style="margin-top:10px;"><button type="submit" class="btn btn-primary">Editar</button></div>' +
                                            '</div>' +
                                            '<div class="col-sm-6">' +
                                                '<a href="{{ url("dashboard/delete-images/".$imagen->id) }}" class="btn btn-danger">Eliminar</a> ' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</form>' +
                            '@endif @endforeach' +
                            '@endif';
                            $('#atributos-dinamicos').html($template);
                    break
                }
            }
        </script>
@endsection

