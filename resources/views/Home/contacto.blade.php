@extends('layouts/content')

@section('title', 'Contactanos')

@section('vendor-style')
  <!-- Vendor css files -->
  <script src="{{ asset('js/old/js.cookie.js') }}" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/wizard/bs-stepper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-pickadate.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-wizard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-number-input.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection


@section('content')
<div class="bs-stepper checkout-tab-steps">
    <form action="{{ route('home.contacto') }}" method="POST">
        @csrf
        <!-- Wizard starts -->
        <div class="bs-stepper-header">
            <div class="step" data-target="#step-cart" role="tab" id="step-cart-trigger">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">
                        <i data-feather="user" class="font-medium-3"></i>
                    </span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Contacto</span>
                        <span class="bs-stepper-subtitle">Dejanos tus dudas o comentarios</span>
                    </span>
                </button>
            </div>
        </div>
        <!-- Wizard ends -->
        @if (session('success'))
            <div class="alert alert-success" role="alert" style="width: 500px;display:block;margin:0px auto;text-align:center;margin-top:60px;padding:8px;">
                <i class="fas fa-thumbs-up" style="margin-right: 10px;"></i> {{ session('success') }}
            </div>
        @endif 
        @if($errors->any())
            <div class="alert alert-danger" >
                <ul style="list-style: none;">
                    @foreach($errors->all() as $key => $error)
                        <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="bs-stepper-content" style="margin-top: 20px;">
            <!-- Checkout Place order starts -->
            <div class="row">
                <div class="col-xs-12 col-md-5">
                    <div class="card" style="border: 2px solid #255992;">
                        <div class="card-header">
                            <h4 class="card-title" style="">Informacion de Contacto</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-12">
                                            <p style="text-align: justify;">Agradecemos te tomes unos minutos y nos cuentes tu experiencia, tus comentarios y sugerencias, eso ayudará a que cada día logremos ofrecer más y mejores servicios.</p>
                                            <ul class="info-resources" style="list-style: none;">
                                                <li class="title-info" style="margin-bottom: 10px;">Correo Electrónico</li>
                                                <li class="sentence-info"> <i class="fas fa-envelope"></i> <a href="mailto:fernando@alphapromos.mx" style="">fernando@alphapromos.mx</a></li>
                                                <li class="sentence-info"> <i class="fas fa-envelope"></i> <a href="mailto:celene@alphapromos.mx" style="">celene@alphapromos.mx</a></li>
                                                <li class="title-info" style="margin-bottom: 10px;margin-top:15px;">Cancún y Rivera Maya</li>
                                                <li class="sentence-info"> <i class="fas fa-phone"></i> (998) 880-5111 / 880-5564 / 140-8894</li>
                                                <li class="title-info" style="margin-bottom: 10px;margin-top:15px;">Ciudad de México</li>
                                                <li class="sentence-info"> <i class="fas fa-phone"></i> (55) 1106-6569</li>
                                                <li class="title-info" style="margin-bottom: 10px;margin-top:15px;">Móvil</li>
                                                <li class="sentence-info"> <i class="fas fa-mobile-alt"></i> (998) 168-5408 y (998) 109 8156</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-7">
                    <div class="card">
                        <!--div class="card-header">
                            <h4 class="card-title">Horizontal Form with Icons</h4>
                        </div-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="fname-icon">Nombre Completo</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                        <span class="input-group-text" style="border-radius: 0.357rem;border-radius: 0.357rem;border-top: 1px solid #d8d6de;border-bottom: 1px solid #d8d6de;border-top-radius: 0px;border-radius-top: 0px;border-top-right-radius: 0px;border-bottom-right-radius: 0px;border-left: 1px solid #d8d6de;"><i data-feather="user"></i></span>
                                        <input
                                            type="text"
                                            id="fname-icon"
                                            class="form-control"
                                            name="nombre"
                                            placeholder="John Doe"
                                        />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="email-icon">Email</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                        <span class="input-group-text" style="border-radius: 0.357rem;border-radius: 0.357rem;border-top: 1px solid #d8d6de;border-bottom: 1px solid #d8d6de;border-top-radius: 0px;border-radius-top: 0px;border-top-right-radius: 0px;border-bottom-right-radius: 0px;border-left: 1px solid #d8d6de;"><i data-feather="mail"></i></span>
                                        <input
                                            type="email"
                                            id="email-icon"
                                            class="form-control"
                                            name="email"
                                            placeholder="Email"
                                        />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="contact-icon">Telefono</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                        <span class="input-group-text" style="border-radius: 0.357rem;border-radius: 0.357rem;border-top: 1px solid #d8d6de;border-bottom: 1px solid #d8d6de;border-top-radius: 0px;border-radius-top: 0px;border-top-right-radius: 0px;border-bottom-right-radius: 0px;border-left: 1px solid #d8d6de;"><i data-feather="smartphone"></i></span>
                                        <input
                                            type="number"
                                            id="contact-icon"
                                            class="form-control"
                                            name="celular"
                                            placeholder="Mobile"
                                        />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="pass-icon">Comentarios</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <textarea
                                                class="form-control"
                                                name="comentarios"
                                                rows="3"
                                                placeholder="Textarea"
                                                ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary me-1">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
        </div>
    </form>
</div>
@endsection

@section('vendor-script')
    <!-- Vendor js files -->
    <script src="{{ asset('vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('vendors/js/forms/cleave/cleave.min.js')}}"></script>
    <script src="{{ asset('vendors/js/forms/cleave/addons/cleave-phone.us.js')}}"></script>
@endsection

@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset('js/scripts/pages/app-ecommerce-checkoutt.js') }}"></script>
  <script src="{{ asset('js/scripts/forms/pickers/form-pickers.js') }}"></script>
  <script src="{{ asset('js/scripts/forms/form-input-mask.js') }}"></script>
@endsection