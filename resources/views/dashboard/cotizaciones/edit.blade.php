@extends('layouts/contentLayoutMaster')

@section('title', 'Editando Cotizacion')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset('css/old/pickadate.css') }}">
        <script src="{{ asset('js/old/jquery.min.js')}}"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section('content')

<section id="basic-vertical-layouts">
  <div class="row match-height">
    <div class="offset-md-3 col-md-6 col-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fas fa-pencil-alt" style="font-size: 30px;color: orange;margin-right: 10px;"></i>Editando Cotización con Clave: Alpha-{{ $cotizacion->id }}</h4>
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
              <form class="form form-vertical" id='editCotizacion' enctype="multipart/form-data" method="POST" action="{{ url('/dashboard/edit-cotizacion/'.$cotizacion->id) }}">
                @csrf
                <div class="form-body">
                  <div class="row">
                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label for="password-icon">Estatus de la Cotización <span class="obligated">*</span> </label>
                            <fieldset class="form-group">
                                <select class="form-control" id="status" name="status">
                                    @if ($cotizacion->status == "Pendiente")
                                        <option value="{{ $cotizacion->status }}" selected> {{ $cotizacion->status}} </option>
                                        <option class="text-danger" value="Cancelada">Cancelada</option>
                                        <option class='text-success' value="Aprobada">Aprobada</option>
                                        
                                    @elseif($cotizacion->status == "Cancelada")
                                        <option value="{{ $cotizacion->status }}" selected> {{ $cotizacion->status}} </option>
                                        <option class='text-warning' value="Pendiente">Pendiente</option>
                                        <option class='text-success' value="Aprobada">Aprobada</option>
                                    @else
                                        <option value="{{ $cotizacion->status }}" selected> {{ $cotizacion->status}} </option>
                                        <option class="text-danger" value="Cancelada">Cancelada</option>
                                        <option class='text-warning' value="Pendiente">Pendiente</option>
                                    @endif
                                    
                                </select>
                            </fieldset>        
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                        <div class="form-group">
                            <label for="first-name-icon">Nombre <span class="obligated">*</span></label>
                            <div class="position-relative has-icon-left">
                                <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $cotizacion->nombre ?? old('$request->nombre') }}">
                                <div class="form-control-position">
                                    <i class="icon-form feather icon-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                      <div class="form-group">
                          <label for="first-name-icon">Apellidos <span class="obligated">*</span></label>
                          <div class="position-relative has-icon-left">
                            <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{ $cotizacion->apellidos ?? old('$request->apellidos') }}">
                            <div class="form-control-position">
                              <i class="icon-form feather icon-user"></i>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                      <div class="form-group">
                          <label for="first-name-icon">Email <span class="obligated">*</span></label>
                          <div class="position-relative has-icon-left">
                            <input type="email" class="form-control" name="email" id="email" value="{{ $cotizacion->email ?? old('$request->email') }}">
                            <div class="form-control-position">
                              <i class="icon-form feather icon-mail"></i>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                      <div class="form-group">
                          <label for="first-name-icon">Celular <span class="obligated">*</span></label>
                          <div class="position-relative has-icon-left">
                            <input type="number" class="form-control" name="celular" id="celular" value="{{ $cotizacion->celular ?? old('$request->celular') }}">
                            <div class="form-control-position">
                              <i class="icon-form feather icon-smartphone"></i>
                            </div>
                          </div>
                      </div>
                    </div>
                    <h2 style="text-align: center;">Producto(s)</h2>
                    @php
                        $cont = 0;
                    @endphp
                    @foreach ($productos_cot as $product)
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                @php
                                    $img = asset('imgs/no_disp.png');
                                    if($product->images != null)
                                    {
                                        $img = json_decode($product->images)[0];
                                        if(!Str::contains($img,['https','http']))
                                        {
                                            $img = Storage::url($img);
                                        }
                                    }
                                @endphp 
                                <div id="img-hold"><img src="{{ $img }}" alt="Producto Img" style="width: 130px; display:block;margin:0px auto;"></div>
                                <p style="text-align: center">{{ $product->nombre}}</p>
                                <!--label for="password-icon">Productos <span class="obligated">*</span></label>
                                <fieldset class="form-group">
                                    <select class="form-control producto_select-{{$cont}}" id="producto_id" name="productos_id[]">
                                    @foreach ($productos as $producto)
                                        @if ($product->id == $producto->id)
                                            <option value="{{ $producto->id }}" selected>{{$producto->modelo}} - {{ $producto->nombre}} - {{ $producto->proveedor }} </option>
                                        @endif  
                                        <option value="{{ $producto->id }}">{{$producto->SDK}} - {{ $producto->nickname}} - {{ $producto->color }} - {{ $producto->proveedor }} </option>    
                                    @endforeach
                                    </select>
                                </fieldset-->        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="password-icon">Pantone Solicitado <span class="obligated">*</span></label>
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" name="pantones[]" id="color" value="{{$product->pantones ?? old('$request->pantones') }}">
                                    <div class="form-control-position">
                                        <i class="icon-form fas fa-tint"></i>
                                    </div>
                                </div>        
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                @php
                                    $servicios = explode(",", $product->metodos_impresion);
                                @endphp
                                <label for="password-icon">Metodo de Impresión solicitado <span class="obligated">*</span></label>
                                <fieldset class="form-group">
                                    <select class="form-control servicio_id" id="servicio_id" name="servicio_id[]">
                                        <option value="default"> Selecciona una opcion</option>
                                        @foreach ($servicios as $servicio)
                                            @if (trim($product->impresion_metodo) == trim($servicio))
                                                <option value="{{ trim($servicio) }}" selected> {{ trim($servicio) }} </option> 
                                            @else
                                                <option value="{{ trim($servicio) }}"> {{ trim($servicio) }} </option> 
                                            @endif
                        
                                        @endforeach
                                    </select>
                                </fieldset>      
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="email-id-icon">Fecha deseable de Entrega <span class="obligated">*</span></label>
                                <div class="position-relative has-icon-left">
                                    <input type='text' id="fecha_deseable" name="fecha_deseable[]" class="form-control pickadate" value="{{ $product->fecha_deseable ?? old('$request->fecha_deseable') }}" />
                                    <input type="hidden" class="form-control">
                                    <div class="form-control-position">
                                    <i class="icon-form feather icon-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="first-name-icon">Nº de pzas a cotizar <span class="obligated">*</span></label>
                                <div class="position-relative has-icon-left">
                                    <input type="number" class="form-control" name="cantidad_pzas[]" id="cantidad_piezas" value="{{ $product->num_pzas ?? old('$request->cantidad_piezas') }}">
                                    <div class="form-control-position">
                                    <i class="icon-form feather icon-hash"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="first-name-icon">Tipografía</label>
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" name="tipografia[]" id="tipografia" value="{{ $product->tipografia ?? old('$request->tipografia') }}">
                                    <div class="form-control-position">
                                        <i class="icon-form fas fa-font"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="first-name-icon">Medidas solicitadas (cms)</label>
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" name="medidas_deseables[]" id="medidas_deseables" value="{{ $product->medidas_deseables ?? old('$request->medidas_deseables') }}">
                                    <div class="form-control-position">
                                        <i class="icon-form fas fa-ruler"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="first-name-icon">Nº. de Tintas solicitadas</label>
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" name="numero_tintas[]" id="numero_tintas" value="{{ $product->numero_tintas ?? old('$request->numero_tintas') }}">
                                    <div class="form-control-position">
                                        <i class="icon-form fas fa-paint-brush"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="first-name-icon">Precio x pza. <span class="obligated">*</span></label>
                                <div class="position-relative has-icon-left">
                                    <input type="text" class="form-control" name="precio_pza[]" id="precio_pza" value="{{ $product->precio_pza ?? old('$request->precio_pza') }}">
                                    <input type="hidden" class="form-control" name="producto_id[]" id="producto_id" value="{{ $product->id }}">
                                    <div class="form-control-position">
                                        <i class="icon-form feather icon-dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(".servicio_id-{{$cont}}").select2();
                            $(".producto_select-{{$cont}}").select2();
                            $('.producto_select-{{$cont}}').on("select2:select", function (e) {
                            var id = $(this).val();
                            $.ajax({
                                url:"/ajax/colores/"+id,
                                method:"GET",
                                dataType : "json",
                                success:function(data)
                                {   
                                    console.log(data);
                                    var img_producto = '<img src="'+data[2][0]+'" style="width:200px;display:block;margin:0px auto;" alt="Producto" />';
                                    $("#img-hold").html("");
                                    $("#img-hold").append(img_producto);
                                }
                            });
                            });
                        </script>
                        @php
                            $cont++;
                        @endphp
                    @endforeach

                    <h2 style="text-align: center;">Billing & Dirección</h2>
                    
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                            <label for="first-name-icon">Forma de Pago <span class="obligated">*</span></label>
                            <select class="form-select" id="forma_pago" name="forma_pago">
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Oxxo">Oxxo</option>
                            </select>
                      </div>
                    </div>
                    
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="email-id-icon">Nombre del archivo: (descargalo)</label>
                            <div class="position-relative has-icon-left">     
                                <a href="{{ url('/dashboard/download-cotizacion/'.$cotizacion->id) }}" class="form-control">Assets.zip</a>
                                <div class="form-control-position">
                                    <i class="icon-form feather icon-download"></i>
                                </div>
                            </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="email-id-icon">Logo a sustituir</label>
                            <div class="position-relative has-icon-left">     
                                <input type="file" multiple="" name="logo_img" id="logo_img" class="form-control">
                                <div class="form-control-position">
                                    <i class="icon-form feather icon-upload"></i>
                                </div>
                            </div>
                      </div>
                    </div>
                    
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                          <label for="first-name-icon">Precio Subtotal <span class="obligated">*</span></label>
                          <div class="position-relative has-icon-left">
                              <input type="text" class="form-control" name="precio_subtotal" id="precio_subtotal" value="{{ $cotizacion->precio_subtotal ?? old('$request->precio_subtotal') }}">
                              <div class="form-control-position">
                                  <i class="icon-form feather icon-dollar-sign"></i>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                          <label for="first-name-icon">Costo Mano de Obra <span class="obligated">*</span></label>
                          <div class="position-relative has-icon-left">
                              <input type="text" class="form-control" name="mano_x_obra" id="mano_x_obra" value="{{ $cotizacion->mano_x_obra ?? old('$request->mano_x_obra') }}">
                              <div class="form-control-position">
                                  <i class="icon-form feather icon-dollar-sign"></i>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                          <label for="first-name-icon">Precio Total <span class="obligated">*</span></label>
                          <div class="position-relative has-icon-left">
                              <input type="text" class="form-control" name="precio_total" id="precio_total" value="{{ $cotizacion->precio_total ?? old('$request->precio_total') }}">
                              <input type="hidden" class="form-control" name="total_productos" id="total_productos" value="{{ $cotizacion->total_productos }}">
                              <div class="form-control-position">
                                  <i class="icon-form feather icon-dollar-sign"></i>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                          <label for="first-name-icon">Colonia <span class="obligated">*</span></label>
                          <div class="position-relative has-icon-left">
                              <input type="text" class="form-control" name="colonia" id="colonia" value="{{ $cotizacion->colonia ?? old('$request->colonia') }}">
                              <div class="form-control-position">
                                  <i class="icon-form feather icon-dollar-sign"></i>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                          <label for="first-name-icon">Estado <span class="obligated">*</span></label>
                          <div class="position-relative has-icon-left">
                              <input type="text" class="form-control" name="estado" id="estado" value="{{ $cotizacion->estado ?? old('$request->estado') }}">
                              <div class="form-control-position">
                                  <i class="icon-form feather icon-dollar-sign"></i>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                          <label for="first-name-icon">CP <span class="obligated">*</span></label>
                          <div class="position-relative has-icon-left">
                              <input type="text" class="form-control" name="cp" id="cp" value="{{ $cotizacion->cp ?? old('$request->cp') }}">
                              <div class="form-control-position">
                                  <i class="icon-form feather icon-dollar-sign"></i>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                          <label for="first-name-icon">Nº Ext <span class="obligated">*</span></label>
                          <div class="position-relative has-icon-left">
                              <input type="text" class="form-control" name="no_ext" id="no_ext" value="{{ $cotizacion->no_ext ?? old('$request->no_ext') }}">
                              <div class="form-control-position">
                                  <i class="icon-form feather icon-dollar-sign"></i>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="contact-info-icon">Calle</label>
                            <div class="position-relative has-icon-left">
                                <fieldset class="form-group">
                                    <textarea class="form-control" name="calle" id="calle" rows="2">{{ $cotizacion->calle ?? old('$request->calle') }}</textarea>
                                </fieldset>
                                <div class="form-control-position">
                                    <i class="icon-form fas fa-paragraph"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="form-group">
                            <label for="contact-info-icon">Comentarios</label>
                            <div class="position-relative has-icon-left">
                                <fieldset class="form-group">
                                    <textarea class="form-control" name="comentarios" id="comentarios" rows="3">{{ $cotizacion->comentarios ?? old('$request->comentarios') }}</textarea>
                                </fieldset>
                                <div class="form-control-position">
                                    <i class="icon-form fas fa-paragraph"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">Editar</button>
                        <a href="{{ url('/dashboard/cotizaciones')}}" class="btn btn-danger mr-1 mb-1">Cancelar</a>
                        <div id="loading" style="display: none;">
                            <img src="{{ asset('img/items/loading.svg') }}" alt="Loading..." style="width: 50px;">
                            <span>Editando...</span>
                        </div>
                    </div>
                  </div><!-- End row -->
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
        <script src="{{ asset('js/old/picker.js') }}"></script>
        <script src="{{ asset('js/old/picker.date.js') }}"></script>
        <script src="{{ asset('js/old/picker.time.js') }}"></script>
        <script src="{{ asset('js/old/legacy.js') }}"></script>
        <script src="{{ asset('js/old/pick-a-datetime.js') }}"></script>
@endsection
