@extends('layouts/contentLayoutMaster')

@section('title', 'Editando Inovice')

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
                    Invoice - Cliente - {{ $order->name . ' ' . $order->lastname }}
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
                        <form class="form form-vertical" id='editInvoice' enctype="multipart/form-data" method="POST" action="{{ url('/dashboard/edit-cotizacion-invoice/'.$order->order_id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="first-name-icon">Folio <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="folio" placeholder="30 dias" value="{{ $invoice->folio ?? old('$request->folio') }}">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-smartphone"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="first-name-icon">Número de días para realizar el pago <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="payment_days" placeholder="30 dias" value="{{ $invoice->payment_days ?? old('$request->payment_days') }}">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-smartphone"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="first-name-icon">Tiempo de entrega (Numero de dias hábiles) <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="deliver_days" value="{{ $invoice->deliver_days ?? old('$request->deliver_days') }}" placeholder="12 dias">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-smartphone"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="first-name-icon">Lugar de entrega (Estado de la república) <span class="obligated">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" class="form-control" name="place" value="{{ $invoice->place ?? old('$request->place') }}" placeholder="CDMX">
                                            <div class="form-control-position">
                                                <i class="icon-form feather icon-smartphone"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Editar</button>
                                    <a href="{{ url('/dashboard/show-cotizacion/' . $order->order_id)}}" class="btn btn-danger mr-1 mb-1">Regresar</a>
                                    <div id="loading" style="display: none;">
                                        <img src="{{ asset('img/items/loading.svg') }}" alt="Loading..." style="width: 50px;">
                                        <span>Editando...</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
@endsection
