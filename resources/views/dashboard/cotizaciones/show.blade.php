@extends('layouts/contentLayoutMaster')

@section('title', 'Cotizacion')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/v3/dashboard/cotizacion.css') }}">
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
    @if (session('warning'))
        <div class="bg-warning" style="padding:10px;margin-bottom:30px;border-radius: 5px;color:white;text-align:center;">
            <p style="margin-bottom: 0px;"><i class="fas fa-exclamation" style="margin-right: 10px;"></i> {{ session('warning') }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <div class="card">
                <div class="card-body">
                    <div class="accordion" id="accordionProducts">
                        @php
                            $index = 0;
                        @endphp
                        @foreach ($order_x_products as $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Producto - {{ $item->name }}
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse {{ ($index == 0) ? 'show' : ''}}" aria-labelledby="headingOne" data-bs-parent="#accordionProducts">
                                    <div class="accordion-body">
                                        <img src="{{ $item->product->preview }}" class="previewImg" alt="{{ $item->name }}">
                                        <p class="text-center mb-0">{{ $item->name }}</p>
                                        <p class="text-center"><span class="badge bg-light-secondary">{{ $item->product->code }}</span></p>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="headline">Proveedor</p>
                                                <p>{{ $item->provider }}</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="headline">Fecha de Entrega</p>
                                                <p>{{ $order->date_transform }}</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="headline">Pantone</p>
                                                <p>{{ $item->pantone }}</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="headline">Nº Tintas</p>
                                                <p>{{ $item->num_ink }}</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="headline">Nº Pzas</p>
                                                <p>{{ $item->num_pzas }}</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="headline">Método Impresión</p>
                                                <p>{{ $item->printing_method }}</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="headline">Tipografía</p>
                                                <p>{{ $item->typography }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $index++;
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <ul class="nav nav-pills mb-2">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i data-feather="bookmark" class="font-medium-3 me-50"></i>
                        <span class="fw-bold">Detalles de la cotizacion</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.edit.cotizacion',['id' => $order->order_id]) }}">
                        <i data-feather="edit" class="font-medium-3 me-50"></i>
                        <span class="fw-bold">Editar Cotizacion</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.edit.cotizacion.invoice',['order_id' => $order->order_id]) }}">
                        <i data-feather="edit" class="font-medium-3 me-50"></i>
                        <span class="fw-bold">Editar Invoice</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.order.invoice',['id' => $order->order_id]) }}" target="_blank">
                        <i data-feather="edit" class="font-medium-3 me-50"></i>
                        <span class="fw-bold">Generar Invoice</span>
                    </a>
                </li>
            </ul>

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
                                <dt class="col-sm-4 fw-bolder mb-1">Estatus:</dt>
                                <dd class="col-sm-8 mb-1 badge {{ $order->bg_status }}">{{ $order->status }}</dd>

                                <dt class="col-sm-4 fw-bolder mb-1">Cliente:</dt>
                                <dd class="col-sm-8 mb-1">{{ $order->name }} {{ $order->lastname }}</dd>

                                <dt class="col-sm-4 fw-bolder mb-1">Telefono:</dt>
                                <dd class="col-sm-8 mb-1">{{ $order->code_area }} {{ $order->phone }}</dd>

                                <dt class="col-sm-4 fw-bolder mb-1">País:</dt>
                                <dd class="col-sm-8 mb-1">{{ $order->country }}</dd>

                                <dt class="col-sm-4 fw-bolder mb-1">Calle:</dt>
                                <dd class="col-sm-8 mb-1">{{ $order->address }}</dd>
                            </dl>
                        </div>
                        <div class="col-xl-5 col-12">
                        <dl class="row mb-0">
                            <dt class="col-sm-4 fw-bolder mb-1">Nº Productos:</dt>
                            <dd class="col-sm-8 mb-1">{{ $order->total_products }}</dd>

                            <dt class="col-sm-4 fw-bolder mb-1">Email:</dt>
                            <dd class="col-sm-8 mb-1">{{ $order->email }}</dd>

                            <dt class="col-sm-4 fw-bolder mb-1">WhatsApp:</dt>
                            <dd class="col-sm-8 mb-1">{{ ($order->isWhatsApp) ? 'Si' : 'No' }}</dd>

                            <dt class="col-sm-4 fw-bolder mb-1">Estado:</dt>
                            <dd class="col-sm-8 mb-1">{{ $order->state }}</dd>
                            

                            <dt class="col-sm-4 fw-bolder mb-1">CP:</dt>
                            <dd class="col-sm-8 mb-1">{{ $order->cp }}</dd>

                        </dl>
                        </div>
                    </div>
                </div>
            </div>
            <!-- current plan -->
            <div class="card">
                <div class="card-header">
                <h4 class="card-title">Información del Invoice</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-2 row" style="">
                                <div style="margin-right:10px;" class="col-12 col-md-7">
                                    <h5><span class="badge badge-light-primary ms-50">Producto</span></h5>
                                    @foreach ($order_x_products as $item)
                                        <p>{{ $item->name }}</p>
                                    @endforeach
                                </div>
                                <div class="col-12 col-md-4">
                                    <h5><span class="badge badge-light-primary ms-50">Costo x Pza</span></h5>
                                    @foreach ($order_x_products as $item)
                                        <p>$ {{ $item->price_x_unid }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning mb-2" role="alert">
                                <h6 class="alert-heading">Se necesita poner precios para generar un invoice</h6>
                                <div class="alert-body fw-normal">De lo contrario no se podrá generar</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2" style="">
                                <div style="margin-right:10px;">
                                    <h5><span class="badge badge-light-primary ms-50">Folio</span></h5>
                                    <p>{{ ($invoice == null) ? 'Sin especificar' : $invoice->folio }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2" style="">
                                <div style="margin-right:10px;">
                                    <h5><span class="badge badge-light-primary ms-50">Plazo para pagar el invoice</span></h5>
                                    <p>{{ $invoice->payment_days }} días</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2" style="">
                                <div style="margin-right:10px;">
                                    <h5><span class="badge badge-light-primary ms-50">Plazo para la entrega de producto</span></h5>
                                    <p>{{ $invoice->deliver_days }} días hábiles</p>
                                </div>
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
                            @if ($order->file_path != null)
                                <iframe width="300" height="300" src="{{ Storage::url($order->file_path)}}" frameborder="0"></iframe>
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
