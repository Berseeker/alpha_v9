@extends('layouts/contentLayoutMaster')

@section('title', 'Editando Cotizacion')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset('css/old/pickadate.css') }}">
    <script src="{{ asset('js/old/jquery.min.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <style>
        .alert-danger {
            padding: 4px !important;
        }
    </style>
@endsection

@section('content')

<section id="basic-vertical-layouts">
  <div class="row match-height">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Cliente
                </h4>
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

                    <div class="form-body">
                        <form class="form form-vertical" id='editCotizacion' enctype="multipart/form-data" method="POST" action="{{ url('/dashboard/edit-cotizacion/'.$order->order_id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="password-icon">Estatus de la Cotización <span class="obligated">*</span> </label>
                                        <fieldset class="form-group">
                                            <select class="form-control" id="status" name="order_status">
                                                @if ($order->order_status == "PENDANT")
                                                    <option value="{{ $order->order_status }}" selected> PENDIENTE </option>
                                                    <option class="text-danger" value="CANCEL">CANCELADA</option>
                                                    <option class='text-success' value="APPROVED">APROBADA</option>
                                                    <option class='text-success' value="REVIEWING">EN REVISIÓN</option>

                                                @elseif($order->order_status == "CANCEL")
                                                    <option value="{{ $order->order_status }}" selected> CANCELADA </option>
                                                    <option class='text-warning' value="PENDANT">PENDIENTE</option>
                                                    <option class='text-success' value="APPROVED">APROVADA</option>
                                                    <option class='text-success' value="REVIEWING">EN REVISIÓN</option>

                                                @elseif($order->order_status == "REVIEWING")
                                                    <option class='text-success' value="REVIEWING" selected>EN REVISIÓN</option>
                                                    <option value="{{ $order->order_status }}"> CANCELADA </option>
                                                    <option class='text-warning' value="PENDANT">PENDIENTE</option>
                                                    <option class='text-success' value="APPROVED">APROVADA</option>

                                                @else
                                                    <option value="{{ $order->order_status }}" selected> APROVADA </option>
                                                    <option class="text-danger" value="CANCEL">CANCELADA</option>
                                                    <option class='text-warning' value="PENDANT">PENDIENTE</option>
                                                    <option class='text-success' value="REVIEWING">EN REVISIÓN</option>
                                                @endif

                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="first-name-icon">Nombre <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="name" id="nombre" value="{{ $order->name ?? old('$request->name') }}">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-user"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="first-name-icon">Apellidos <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="lastname" id="apellidos" value="{{ $order->lastname ?? old('$request->lastname') }}">
                                        <div class="form-control-position">
                                            <i class="icon-form feather icon-user"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="first-name-icon">Email <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                        <input type="email" class="form-control" name="email" id="email" value="{{ $order->email ?? old('$request->email') }}">
                                        <div class="form-control-position">
                                            <i class="icon-form feather icon-mail"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="first-name-icon">Celular <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control" name="phone" id="celular" value="{{ $order->phone ?? old('$request->phone') }}">
                                        <div class="form-control-position">
                                            <i class="icon-form feather icon-smartphone"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="email-id-icon">Fecha deseable de Entrega <span class="obligated">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control flatpickr-basic" name="deadline" value="{{ old('$request->deadline') ?? $order->deadline }}" />
                                            </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <h4 style="text-align: center;">Dirección</h4>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="first-name-icon">Pais <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="country" id="colonia" value="{{ $order->country ?? old('$request->country') }}">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="first-name-icon">Ciudad <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="city" id="city" value="{{ $order->city ?? old('$request->city') }}">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="first-name-icon">Estado <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="state" id="estado" value="{{ $order->state ?? old('$request->estado') }}">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="first-name-icon">CP <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="cp" id="cp" value="{{ $order->cp ?? old('$request->cp') }}">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="first-name-icon">Nº Ext <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="no_ext" id="no_ext" value="{{ $order->ext_num ?? old('$request->no_ext') }}">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="first-name-icon">Calle <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="address" id="calle" value="{{ $order->address ?? old('$request->address') }}">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="email-id-icon">Nombre del archivo: (descargalo)</label>
                                        <div class="position-relative has-icon-left">
                                            <a href="{{ url('/dashboard/download-file/'.$order->order_id) }}" class="form-control">Assets.zip</a>
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-download"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <label for="contact-info-icon">Comentarios</label>
                                        <div class="position-relative has-icon-left">
                                            <fieldset class="form-group">
                                                <textarea class="form-control" name="comments" id="comentarios" rows="3" style="resize: none;">{{ $order->comments ?? old('$request->comments') }}</textarea>
                                            </fieldset>
                                            <div class="form-control-position">
                                                <i class="icon-form fas fa-paragraph"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Editar</button>
                                    <a href="{{ url('/dashboard/cotizaciones')}}" class="btn btn-danger mr-1 mb-1">Regresar</a>
                                    <div id="loading" style="display: none;">
                                        <img src="{{ asset('img/items/loading.svg') }}" alt="Loading..." style="width: 50px;">
                                        <span>Editando...</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <h2 class="mt-2 mb-3" style="text-align: center;">Producto(s)</h2>
                        <div class="order-products">
                            @foreach ($order_x_products as $order_x_product)
                            <form action="{{ url('/dashboard/edit-cotizacion/'.$order->order_id) }}" method="POST">
                                @csrf
                                <div class="row mt-2">
                                    <div class="col-12 col-sm-3 mb-2">
                                        <div class="form-group">
                                            <div id="img-hold"><img src="{{ $order_x_product->product->preview }}" alt="Producto Img" style="width: 130px; display:block;margin:0px auto;"></div>
                                            <p style="text-align: center">{{ $order_x_product->name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-9 mb-2">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 mb-2">
                                                <div class="form-group">
                                                    <label for="password-icon">Pantone<span class="obligated">*</span></label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="pantone" value="{{ $order_x_product->pantone ?? old('$request->pantone') }}">
                                                        <div class="form-control-position">
                                                            <i class="icon-form fas fa-tint"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 mb-2">
                                                <div class="form-group">
                                                    <label for="password-icon">Metodo de Impresión<span class="obligated">*</span></label>
                                                    <input type="text" class="form-control" name="printing_method" value="{{ old('$request->printing_method') ?? $order_x_product->printing_method }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 mb-2">
                                                <div class="form-group">
                                                    <label for="first-name-icon">Nº de pzas<span class="obligated">*</span></label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="number" class="form-control" name="num_pzas" value="{{ old('$request->num_pzas') ?? $order_x_product->num_pzas }}">
                                                        <div class="form-control-position">
                                                        <i class="icon-form feather icon-hash"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 mb-2">
                                                <div class="form-group">
                                                    <label for="first-name-icon">Tipografía</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="typography" value="{{ old('$request->typography') ?? $order_x_product->typography }}">
                                                        <div class="form-control-position">
                                                            <i class="icon-form fas fa-font"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 mb-2">
                                                <div class="form-group">
                                                    <label for="first-name-icon">Nº. de Tintas</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="num_ink" value="{{ old('$request->num_ink') ?? $order_x_product->num_ink }}">
                                                        <div class="form-control-position">
                                                            <i class="icon-form fas fa-paint-brush"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 mb-2">
                                                <div class="form-group">
                                                    <label for="first-name-icon">Precio x pza. <span class="obligated">*</span></label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="price_x_unid" value="{{ old('$request->price_x_unid') ?? $order_x_product->price_x_unid }}">
                                                        <input type="hidden" class="form-control" name="product_id" value="{{ $order_x_product->product_id }}">
                                                        <div class="form-control-position">
                                                            <i class="icon-form feather icon-dollar-sign"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--div class="col-12 col-sm-4 mb-2">
                                                <div class="form-group">
                                                    <label for="first-name-icon">IVA %</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="tax" value="{{ old('$request->tax') ?? $order_x_product->tax }}">
                                                        <div class="form-control-position">
                                                            <i class="icon-form feather icon-dollar-sign"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div-->
                                            <div class="col-12 mt-2">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Editar</button>
                                                <a href="{{ url('/dashboard/delete-order-product/'. $order->order_id .'/' . $order_x_product->product_id) }}" class="btn btn-danger mr-1 mb-1">Eliminar</a>
                                                <div id="loading" style="display: none;">
                                                    <img src="{{ asset('img/items/loading.svg') }}" alt="Loading..." style="width: 50px;">
                                                    <span>Editando...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End row -->
                            </form>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
                            + Agregar Producto
                        </button>
                    </div>
                </div><!-- End card-body-->
            </div>
        </div>
    </div>
  </div>
</section>

<!-- Modal Add Product -->
<div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">Agregando Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.add.producto')}}" method="POST" id="addProductForm">
                    @csrf
                    <select id="add-product" class="form-control mb-2" name="addProductId">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"  data-image="{{ $product->preview }}">
                                {{ $product->name .' - '. $product->subcategoria->nombre .' - '. $product->proveedor}}
                            </option>
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-12 col-sm-4 mb-2 mt-2">
                            <input type="text" class="form-control" placeholder="Pantone" name="addPantone" id="addPantone">
                            <input type="hidden" class="form-control" placeholder="Pantone" name="addOrderId" value="{{ $order->order_id }}">
                            <div class="alert" id="addPantone-error" role="alert"></div>
                        </div>
                        <div class="col-12 col-sm-4 mb-2 mt-2">
                            <input type="text" class="form-control" placeholder="Metodo de Impresión" name="addPrintingMethod" id="addPrintingMethod">
                            <div class="alert" id="addPrintingMethod-error" role="alert"></div>
                        </div>
                        <div class="col-12 col-sm-4 mb-2 mt-2">
                            <input type="text" class="form-control" placeholder="No. Pzas" name="addNoPzas" id="addNoPzas">
                            <div class="alert" id="addNoPzas-error" role="alert"></div>
                        </div>
                        <div class="col-12 col-sm-4 mb-2">
                            <input type="text" class="form-control" placeholder="Tipografía" name="addTypography" id="addTypography">
                            <div class="alert" id="addTypography-error" role="alert"></div>
                        </div>
                        <div class="col-12 col-sm-4 mb-2">
                            <input type="text" class="form-control" placeholder="No. Tintas" name="addNoInk" id="addNoInk">
                            <div class="alert" id="addNoInk-error" role="alert"></div>
                        </div>
                        <div class="col-12 col-sm-4 mb-2">
                            <input type="text" class="form-control" placeholder="Precio x pza" name="addCostUnit" id="addCostUnit" value="0.0">
                            <div class="alert" id="addCostUnit-error" role="alert"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="displayErrors"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitAddProduct()">Save changes</button>
            </div>
        </div>
    </div>
</div>

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
    $(document).ready(function() {
        $('#add-product').select2({
            templateResult: formatState
        });
    });

    function formatState (state)
    {
        var optimage = $(state.element).attr('data-image');
        var $opt = $(
            '<span> <img src="' + optimage + '" style="width:80px;" />'  + state.text + '</span>'
        );
       return $opt;
    };

    function submitAddProduct()
    {
        if( $("#addPantone").val().length === 0 ) {
            $("#addPantone-error").addClass('alert-danger');
            $("#addPantone-error").html('Indicar un color');
        }

        if($("#addPrintingMethod").val().length === 0 ) {
            $("#addPrintingMethod-error").addClass('alert-danger');
            $("#addPrintingMethod-error").html('Indicar un metodo de impresión');
        }
        if( $("#addNoPzas").val().length === 0 ) {
            $("#addNoPzas-error").addClass('alert-danger');
            $("#addNoPzas-error").html('Indicar el num. de pzas');
        }
        if( $("#addTypography").val().length === 0 ) {
            $("#addTypography-error").addClass('alert-danger');
            $("#addTypography-error").html('Indicar la tipografia');
        }
        if( $("#addNoInk").val().length === 0 ) {
            $("#addNoInk-error").addClass('alert-danger');
            $("#addNoInk-error").html('Indicar el num. de tintas');
        }

        if ($("#addPantone").val().length > 0 && $("#addPrintingMethod").val().length > 0 && $("#addNoPzas").val().length > 0 && $("#addTypography").val().length > 0 && $("#addNoInk").val().length > 0) {
            $( "#addProductForm" ).submit();
        }
    }
</script>
@endsection
