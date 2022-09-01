@extends('layouts/contentLayoutMaster')

@section('title', 'Cotizacion - '.$cotizacion->id)

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/animate/animate.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/sweetalert2.min.css') }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-sweet-alerts.css') }}">
@endsection

@section('content')
<section class="app-user-view-billing">
  <div class="row">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
      <!-- User Card -->
        @foreach ($productos as $producto)
            <div class="card">
                <div class="card-body">
                    <div class="user-avatar-section">
                    <div class="d-flex align-items-center flex-column">
                        @php
                            $img = asset('imgs/no_disp.png');
                            if($producto->images != null)
                            {
                                $img = json_decode($producto->images)[0];
                                if(!Str::contains($img,['https','http']))
                                {
                                    $img = Storage::url($img);
                                }
                            }
                        @endphp 
                        <img
                        class="img-fluid rounded mt-3 mb-2"
                        src="{{ $img }}"
                        height="110"
                        width="110"
                        alt="Producto"
                        />
                        <div class="user-info text-center">
                        <h4>{{ $producto->nombre }}</h4>
                        <span class="badge bg-light-secondary">{{ $producto->modelo }}</span>
                        </div>
                    </div>
                    </div>
                    <h4 class="fw-bolder border-bottom pb-50 mb-1">Detalles</h4>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Proveedor:</span>
                                <span>{{ $producto->proveedor }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Colores disponibles:</span>
                                <span>{{ $producto->colores }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Fecha deseable de entrega:</span>
                                <span class="badge bg-light-success">{{ $producto->fecha_deseable }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Pantones solicitados:</span>
                                <span>{{ $producto->pantones }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Tipografia solicitada:</span>
                                <span>{{ $producto->tipografia }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Numero de Tintas:</span>
                                <span>{{ $producto->numero_tintas }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Piezas solicitadas:</span>
                                <span>{{ $producto->num_pzas }} pzas</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Area de impresion:</span>
                                <span>{{ $producto->area_impresion }}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Metodos de impresion:</span>
                                <span>{{ $producto->metodos_impresion }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
        
      <!-- /User Card -->
    </div>
    <!--/ User Sidebar -->

    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
      <!-- User Pills -->
      <ul class="nav nav-pills mb-2">
        <li class="nav-item">
          <a class="nav-link active" href="#">
            <i data-feather="bookmark" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Detalles de la cotizacion</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard.edit.cotizacion',['id' => $cotizacion->id]) }}">
            <i data-feather="edit" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Editar Cotizacion</span>
          </a>
        </li>
      </ul>
      <!--/ User Pills -->

      <!-- / current plan -->

        <!-- Billing Address -->
        <div class="card">
            <div class="card-header">
            <h4 class="card-title mb-50">Informacion del Cliente</h4>
            <!--button
                class="btn btn-primary btn-sm edit-address"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#addNewAddressModal"
            >
                Edit address
            </button-->
            </div>
            <div class="card-body">
            <div class="row">
                <div class="col-xl-7 col-12">
                <dl class="row mb-0">
                    <dt class="col-sm-4 fw-bolder mb-1">Cliente:</dt>
                    <dd class="col-sm-8 mb-1">{{ $cotizacion->nombre }} {{ $cotizacion->apellidos }}</dd>

                    <dt class="col-sm-4 fw-bolder mb-1">Email:</dt>
                    <dd class="col-sm-8 mb-1">{{ $cotizacion->email }}</dd>

                    <dt class="col-sm-4 fw-bolder mb-1">Productos cotizados:</dt>
                    <dd class="col-sm-8 mb-1">{{ $cotizacion->total_productos }}</dd>

                    <dt class="col-sm-4 fw-bolder mb-1">Status Cotizacion:</dt>
                    <dd class="col-sm-8 mb-1 badge bg-light-warning">{{ $cotizacion->status }}</dd>

                    <dt class="col-sm-4 fw-bolder mb-1">Calle:</dt>
                    <dd class="col-sm-8 mb-1">{{ $cotizacion->calle }}</dd>
                </dl>
                </div>
                <div class="col-xl-5 col-12">
                <dl class="row mb-0">
                    <dt class="col-sm-4 fw-bolder mb-1">Colonia:</dt>
                    <dd class="col-sm-8 mb-1">{{ $cotizacion->colonia }}</dd>

                    <dt class="col-sm-4 fw-bolder mb-1">CP:</dt>
                    <dd class="col-sm-8 mb-1">{{ $cotizacion->cp }}</dd>

                    <dt class="col-sm-4 fw-bolder mb-1">Estado:</dt>
                    <dd class="col-sm-8 mb-1">{{ $cotizacion->estado }}</dd>

                    <dt class="col-sm-4 fw-bolder mb-1">Telefono:</dt>
                    <dd class="col-sm-8 mb-1">{{ $cotizacion->codigo_area }} {{ $cotizacion->celular }}</dd>
                </dl>
                </div>
            </div>
            </div>
        </div>
        <!-- current plan -->
        <div class="card">
            <div class="card-header">
            <h4 class="card-title">Precios de la Cotizacion</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2 pb-50">
                            @php
                                $cont = 0;
                            @endphp
                            @foreach ($productos as $producto)
                                <h5 style="margin-top:8px;margin-bottom:0px;"><strong>{{$producto->nombre}}</strong></h5>
                                <span>Costo x pza: $ {{ json_decode($cotizacion->precio_pza)[$cont] }}</span>
                                @php
                                    $cont++;
                                @endphp
                            @endforeach
                        </div>
                        <div class="mb-2 pb-50">
                            @php
                                $cont = 0;
                            @endphp
                            @foreach ($productos as $producto)
                                <h5 style="margin-top:8px;margin-bottom:0px;"><strong>{{$producto->nombre}}</strong></h5>
                                <span>Costo x producto: $ {{ json_decode($cotizacion->precio_x_producto)[$cont] }}</span>
                                @php
                                    $cont++;
                                @endphp
                            @endforeach
                        </div>
                        <div class="mb-2 mb-md-1" style="display: inline-flex;">
                            <div style="margin-right:10px;">
                                <h5><span class="badge badge-light-primary ms-50">Subtotal</span></h5>
                                <span>$ {{ $cotizacion->precio_subtotal }}</span>
                            </div>
                            <div>
                                <h5><span class="badge badge-light-primary ms-50">Mano x Obra</span></h5>
                                <span>$ {{ $cotizacion->mano_x_obra }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-warning mb-2" role="alert">
                            <h6 class="alert-heading">Necesito toda tu atencion! - Cuidado al editar lo precios</h6>
                            <div class="alert-body fw-normal">Grandes poderes conllevan una gran responsabilidad</div>
                        </div>
                        <div class="plan-statistics pt-1">
                            <div class="d-flex justify-content-between">
                            <h5 class="fw-bolder">Precio Total</h5>
                            <h5 class="fw-bolder">$ {{ $cotizacion->precio_total }}</h5>
                            </div>
                            <div class="progress">
                            <div
                                class="progress-bar w-100"
                                role="progressbar"
                                aria-valuenow="75"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                            </div>
                            <!--p class="mt-50">4 days remaining until your plan requires update</p-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- payment methods -->
        <div class="card">
            <div class="card-header">
            <h4 class="card-title mb-50">Archivos Multimedia</h4>
            <!--button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewCard">
                <i data-feather="plus"></i>
                <span>Add Card</span>
            </button-->
            </div>
            <div class="card-body">
            <div class="added-cards">
                <div class="cardMaster rounded border p-2 mb-1">
                    <div class="d-flex justify-content-between flex-sm-row flex-column">
                        <div class="card-information">
                        @if ($cotizacion->logo_img != null)
                            @php
                                $archivos = json_decode($cotizacion->logo_img);
                            @endphp
                            @foreach ($archivos as $file)
                                <iframe width="300" height="300" src="{{ Storage::url($file)}}" frameborder="0"></iframe>
                            @endforeach
                        @else 
                            <p>No Contiene Archivos Multimedia</p>
                        @endif 
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
      <!-- / payment methods -->

      <!--/ Billing Address -->
    </div>
    <!--/ User Content -->
  </div>
</section>

@include('partials/modal-edit-user')
@include('partials/modal-upgrade-plan')
@include('partials/modal-edit-cc')
@include('partials/modal-add-new-cc')
@include('partials/modal-add-new-address')
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/cleave/cleave.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/polyfill.min.js') }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset('js/scripts/pages/modal-edit-user.js') }}"></script>
  <script src="{{ asset('js/scripts/pages/modal-add-new-cc.js') }}"></script>
  <script src="{{ asset('js/scripts/pages/modal-edit-cc.js') }}"></script>
  <script src="{{ asset('js/scripts/pages/modal-add-new-address.js') }}"></script>
  <script src="{{ asset('js/scripts/pages/app-user-view-billing.js') }}"></script>
  <script src="{{ asset('js/scripts/pages/app-user-view.js') }}"></script>
@endsection
