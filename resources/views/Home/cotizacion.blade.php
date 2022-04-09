@extends('layouts/content')

@section('title', 'Cotizacion')

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
    <form action="{{ route('home.cotizacion') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Wizard starts -->
        <div class="bs-stepper-header">
            <div class="step" data-target="#step-cart" role="tab" id="step-cart-trigger">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">
                        <i data-feather="shopping-cart" class="font-medium-3"></i>
                    </span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Carrito</span>
                        <span class="bs-stepper-subtitle">Your Cart Items</span>
                    </span>
                </button>
            </div>
            <div class="line">
                <i data-feather="chevron-right" class="font-medium-2"></i>
            </div>
            <div class="step" data-target="#step-address" role="tab" id="step-address-trigger">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">
                        <i data-feather="home" class="font-medium-3"></i>
                    </span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Direccion</span>
                        <span class="bs-stepper-subtitle">Enter Your Address</span>
                    </span>
                </button>
            </div>
            <div class="line">
                <i data-feather="chevron-right" class="font-medium-2"></i>
            </div>
            <div class="step" data-target="#step-payment" role="tab" id="step-payment-trigger">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">
                        <i data-feather="credit-card" class="font-medium-3"></i>
                    </span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Cotiza</span>
                        <span class="bs-stepper-subtitle">Select Payment Method</span>
                    </span>
                </button>
            </div>
        </div>
        <!-- Wizard ends -->
        @if (session('success'))
            <div class="alert alert-success" role="alert" style="width: 600px;display:block;margin:0px auto;text-align:center;margin-top:60px;">
                <i class="fas fa-thumbs-up" style="margin-right: 10px;"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
        <div class="bs-stepper-content">
            <!-- Checkout Place order starts -->
            <div id="step-cart" class="content" role="tabpanel" aria-labelledby="step-cart-trigger">
                @if (empty($productos))
                    <img src="{{ asset('imgs/logos/empty-cart.png') }}" alt="Carrito Vacio">
                @else
                    <div id="place-order" class="list-view product-checkout">
                        <!-- Checkout Place Order Left starts -->
                        <div class="checkout-items">
                            @foreach ($productos as $producto)
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
                                <div class="card ecommerce-card">
                                    <div class="item-img">
                                        <a href="{{url('app/ecommerce/details')}}">
                                            <img src="{{$img}}" alt="img-placeholder" />
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="item-name">
                                            <h6 class="mb-0"><a href="{{url('app/ecommerce/details')}}" class="text-body">{{ $producto->nombre}}</a></h6>
                                            <span class="item-company">By <a href="#" class="company-name">AlphaPromos</a></span>
                                            <div class="item-rating">
                                                <ul class="unstyled-list list-inline">
                                                <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                                <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                                <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                                <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                                <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <span class="text-success mb-1">{{ $producto->subcategoria->nombre }}</span>
                                        <div class="item-quantity">
                                            <span class="quantity-title">Nº Piezas:</span>
                                            <div class="quantity-counter-wrapper">
                                                <div class="input-group">
                                                    <input type="text" class="quantity-counter" name="numero_pzas[]" value="1" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-quantity" style="margin-top: 8px;">
                                            <span class="quantity-title">Nº Tintas:</span>
                                            <div class="quantity-counter-wrapper">
                                                <div class="input-group">
                                                    <input type="text" class="quantity-counter" name="numero_tintas[]" value="1" />
                                                </div>
                                            </div>
                                        </div>
                                        <!--div class="item-quantity">
                                            <span class="quantity-title">Fecha Tentativa:</span>
                                            <div class="quantity-counter-wrapper">
                                                <div class="input-group">
                                                    <input type="text" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" />
                                                </div>
                                            </div>
                                        </div-->
                                        <!--span class="delivery-date text-muted">Delivery by, Wed Apr 25</span>
                                        <span class="text-success">17% off 4 offers Available</span-->
                                    </div>
                                    <div class="item-options text-center">
                                        <div class="item-wrapper">
                                            <div class="item-cost">
                                                <img src="{{ asset('imgs/logos/alpha_icon.png') }}" alt="AlphaPromos" style="width: 30px;">
                                                <p class="card-text shipping">
                                                    <span class="badge rounded-pill badge-light-success">Cotizacion Gratis</span>
                                                </p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="producto_id[]" value="{{ $producto->id }}" />
                                        <button type="button" class="btn btn-light mt-1 remove-wishlist" sdk="{{ $producto->SDK }}">
                                            <i data-feather="x" class="align-middle me-25"></i>
                                            <span>Quitar</span>
                                        </button>
                                        <!--button type="button" class="btn btn-primary btn-cart move-cart">
                                            <i data-feather="heart" class="align-middle me-25"></i>
                                            <span class="text-truncate">Add to Wishlist</span>
                                        </button-->
                                    </div>
                                </div>  
                            @endforeach
                        </div>
                        <!-- Checkout Place Order Left ends -->

                        <!-- Checkout Place Order Right starts -->
                        <div class="checkout-options">
                            <div class="card">
                                <div class="card-body">
                                    @php
                                        $cont = 0;
                                    @endphp
                                    @foreach ($productos as $producto)
                                        @php
                                            $style = '';
                                            if($cont > 0)
                                                $style = 'margin-top:20px;';
                                        @endphp
                                        <label class="section-label form-label mb-1" style="{{$style}}">Detalles del Producto {{ $producto->nombre }}</label>
                                        <div style="margin-top: 8px;">
                                            <span class="quantity-title">Fecha Tentativa:</span>
                                            <div class="quantity-counter-wrapper">
                                                <div class="input-group">
                                                    <input type="text" class="form-control flatpickr-basic" name="fecha_deseable[]" placeholder="YYYY-MM-DD" />
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-top: 8px;">
                                            <span class="quantity-title">Metodo de Impresion:</span>
                                            <div class="quantity-counter-wrapper">
                                                <div class="input-group">
                                                    <select  class="form-control" name="metodos_impresion[]">
                                                        @foreach (json_decode($producto->impresiones) as $impresion)
                                                            @if ($impresion != '' || $impresion != null)
                                                                <option value="{{$impresion}}">{{$impresion}}</option>
                                                            @endif 
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-top: 8px;">
                                            <span class="quantity-title">Pantones disponibles (color):</span>
                                            <div class="quantity-counter-wrapper">
                                                <div class="input-group">
                                                    <select  class="form-control" name="pantones[]">
                                                        @foreach (json_decode($producto->color) as $color)
                                                            <option value="{{$color}}">{{$color}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-top: 8px;">
                                            <span class="quantity-title">Tipografia:</span>
                                            <div class="quantity-counter-wrapper">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="tipografia[]" />
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $cont++;
                                        @endphp
                                    @endforeach
                                    <hr />
                                    <div class="price-details">
                                        <button type="button" class="btn btn-primary w-100 btn-next place-order">Continuar</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Checkout Place Order Right ends -->
                        </div>
                    </div>
                @endif
            <!-- Checkout Place order Ends -->
            </div>
            <!-- Checkout Customer Address Starts -->
            <div id="step-address" class="content" role="tabpanel" aria-labelledby="step-address-trigger">
                @if (empty($productos))
                    <img src="{{ asset('imgs/logos/empty-cart.png') }}" alt="Carrito Vacio">
                @else
                    <div id="checkout-address" class="list-view product-checkout">
                        <!-- Checkout Customer Address Left starts -->
                        <div class="card">
                            <div class="card-header flex-column align-items-start">
                                <h4 class="card-title">Dirección</h4>
                                <p class="card-text text-muted mt-25">Asegúrese de revisar la dirección de envio!</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-2">
                                        <label class="form-label" cfor="checkout-name">Nombre(s):</label>
                                        <input type="text" id="checkout-name" class="form-control" name="nombre" placeholder="John Doe" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-2">
                                        <label class="form-label" cfor="checkout-name">Apellidos:</label>
                                        <input type="text" id="checkout-lastname" class="form-control" name="apellidos" placeholder="Perez Sanchez" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label" cfor="checkout-celular">Teléfono celular:</label>
                                        <div class="input-group input-group-merge mb-2">
                                            <span class="input-group-text" style="border-radius: 0.357rem;border-radius: 0.357rem;border-top: 1px solid #d8d6de;border-bottom: 1px solid #d8d6de;border-top-radius: 0px;border-radius-top: 0px;border-top-right-radius: 0px;border-bottom-right-radius: 0px;border-left: 1px solid #d8d6de;">MX (+52)</span>
                                            <input
                                                type="text"
                                                class="form-control phone-number-mask"
                                                placeholder="1 234 567 8900"
                                                id="checkout-celular"
                                                name="celular"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-2">
                                            <label class="form-label" cfor="checkout-apt-number">Correo Electronico:</label>
                                            <input
                                                type="email"
                                                id="checkout-email"
                                                class="form-control"
                                                name="email"
                                                placeholder="john@hotmail.com"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-2">
                                            <label class="form-label" cfor="checkout-landmark">Ciudad:</label>
                                            <input
                                                type="text"
                                                id="checkout-ciudad"
                                                class="form-control"
                                                name="ciudad"
                                                placeholder="Cancun"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-2">
                                            <label class="form-label" cfor="checkout-city">Estado:</label>
                                            <input type="text" id="checkout-estado" class="form-control" name="estado" placeholder="QROO" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-2">
                                            <label class="form-label" cfor="checkout-pincode">CP:</label>
                                            <input type="number" id="checkout-cp" class="form-control" name="cp" placeholder="77500" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-2">
                                            <label class="form-label" cfor="checkout-state">Colonia/Municipio:</label>
                                            <input type="text" id="checkout-colonia" class="form-control" name="colonia" placeholder="California" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-2">
                                            <label class="form-label" cfor="checkout-state">Calle:</label>
                                            <input type="text" id="checkout-calle" class="form-control" name="calle" placeholder="Valle de Mitla" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-2">
                                            <label class="form-label" cfor="add-type">Nº Exterior:</label>
                                            <input type="text" id="checkout-no_ext" class="form-control" name="no_ext" placeholder="#34" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary btn-next delivery-address">Siguiente</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Checkout Customer Address Left ends -->

                        <!-- Checkout Customer Address Right starts -->
                        <div class="customer-card">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Detalles del Cliente</h4>
                                </div>
                                <div class="card-body actions">
                                    <p class="card-text mb-0" id="deliver-name"></p>
                                    <p class="card-text" id="deliver-email"></p>
                                    <p class="card-text" id="deliver-estado"></p>
                                    <p class="card-text" id="deliver-colonia"></p>
                                    <p class="card-text" id="deliver-ciudad"></p>
                                    <p class="card-text" id="deliver-calle"></p>
                                    <p class="card-text" id="deliver-celular"></p>
                                    <button type="button" class="btn btn-primary w-100 btn-next delivery-address mt-2">
                                        Siguiente
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Checkout Customer Address Right ends -->
                    </div>
                @endif
            </div>
            <!-- Checkout Customer Address Ends -->
            <!-- Checkout Payment Starts -->
            <div id="step-payment" class="content" role="tabpanel" aria-labelledby="step-payment-trigger">
                @if (empty($productos))
                    <img src="{{ asset('imgs/logos/empty-cart.png') }}" alt="Carrito Vacio">
                @else
            
                    <div id="checkout-payment" class="list-view product-checkout">
                        <div class="payment-type">
                            <div class="card">
                                <div class="card-header flex-column align-items-start">
                                    <h4 class="card-title">Comentarios</h4>
                                    <p class="card-text text-muted mt-25">Aqui nos puedes dejar todas tus dudas o comentarios!</p>
                                </div>
                                <div class="card-body">
                                    <div class="form-check">
                                        <textarea
                                        class="form-control"
                                        name="comentarios"
                                        rows="3"
                                        placeholder="Textarea"
                                        ></textarea>
                                        <input type="hidden" name="total_productos" value="{{ $total_productos }}">
                                    </div>
                                    <!--div class="customer-cvv mt-1 row row-cols-lg-auto">
                                        <div class="col-3 d-flex align-items-center">
                                            <label class="mb-50 form-label" for="card-holder-cvv">Enter CVV:</label>
                                        </div>
                                        <div class="col-4 p-0">
                                            <input type="password" class="form-control mb-50 input-cvv" name="input-cvv" id="card-holder-cvv" />
                                        </div>
                                        <div class="col-3">
                                            <button type="button" class="btn btn-primary btn-cvv mb-50">Continue</button>
                                        </div>
                                    </div-->
                                    <hr class="my-2"/>
                                    <div class="card-header flex-column align-items-start">
                                        <h4 class="card-title">Archivos</h4>
                                        <p class="card-text text-muted mt-25">Aqui nos puedes dejar todas tus dudas o comentarios!</p>
                                        <input class="form-control" type="file" name="archivos[]" multiple />
                                    </div>
                                    
                                    <!--ul class="other-payment-options list-unstyled">
                                        <li class="py-50">
                                            <div class="form-check">
                                                <input type="radio" id="customColorRadio2" name="paymentOptions" class="form-check-input" />
                                                <label class="form-check-label" for="customColorRadio2"> Credit / Debit / ATM Card </label>
                                            </div>
                                        </li>
                                        <li class="py-50">
                                            <div class="form-check">
                                                <input type="radio" id="customColorRadio3" name="paymentOptions" class="form-check-input" />
                                                <label class="form-check-label" for="customColorRadio3"> Net Banking </label>
                                            </div>
                                        </li>
                                        <li class="py-50">
                                            <div class="form-check">
                                                <input type="radio" id="customColorRadio4" name="paymentOptions" class="form-check-input" />
                                                <label class="form-check-label" for="customColorRadio4"> EMI (Easy Installment) </label>
                                            </div>
                                        </li>
                                        <li class="py-50">
                                            <div class="form-check">
                                                <input type="radio" id="customColorRadio5" name="paymentOptions" class="form-check-input" />
                                                <label class="form-check-label" for="customColorRadio5"> Cash On Delivery </label>
                                            </div>
                                        </li>
                                    </ul-->
                                    <hr class="my-2"/>
                                    <!--div class="gift-card mb-25">
                                        <p class="card-text">
                                            <i data-feather="plus-circle" class="me-50 font-medium-5"></i>
                                            <span class="align-middle">Add Gift Card</span>
                                        </p>
                                    </div-->
                                </div>
                            </div>
                        </div>
                        <div class="amount-payable checkout-options">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Resumen Cotizacion</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled price-details">
                                        @foreach ($productos as $producto)
                                           <li class="price-detail">
                                                <div class="details-title">Producto:</div>
                                                <div class="detail-amt discount-amt text-success">{{ $producto->nombre }}</div>
                                            </li> 
                                        @endforeach
                                        <li class="price-detail">
                                            <div class="details-title">Cliente:</div>
                                            <div class="detail-amt discount-amt text-success" id="final-nombre"></div>
                                        </li>
                                        <li class="price-detail">
                                            <div class="details-title">Email:</div>
                                            <div class="detail-amt discount-amt text-success" id="final-email"></div>
                                        </li>
                                        <li class="price-detail">
                                            <div class="details-title">Celular:</div>
                                            <div class="detail-amt discount-amt text-success" id="final-celular"></div>
                                        </li>
                                    </ul>
                                    <hr />
                                   <button type="submit" class="btn btn-primary w-100 btn-next delivery-address mt-2">
                                        Cotizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!-- Checkout Payment Ends -->
            <!-- </div> -->
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
  <script type="text/javascript">
    $(document).ready(function(){
        $('#checkout-name').on('input',function(e){
            $("#deliver-name").html("");
            $("#deliver-name").append($("#checkout-name").val());

            $("#final-nombre").html("");
            $("#final-nombre").append($("#checkout-name").val());
        });
        $('#checkout-email').on('input',function(e){
            $("#deliver-email").html("");
            $("#deliver-email").append($("#checkout-email").val());

            $("#final-email").html("");
            $("#final-email").append($("#checkout-email").val());
        });
        $('#checkout-estado').on('input',function(e){
            $("#deliver-estado").html("");
            $("#deliver-estado").append($("#checkout-estado").val());
        });
        $('#checkout-celular').on('input',function(e){
            $("#deliver-celular").html("");
            $("#deliver-celular").append($("#checkout-celular").val());
            
            $("#final-celular").html("");
            $("#final-celular").append($("#checkout-celular").val());
        });
        $('#checkout-ciudad').on('input',function(e){
            $("#deliver-ciudad").html("");
            $("#deliver-ciudad").append($("#checkout-ciudad").val());
        });
        $('#checkout-calle').on('input',function(e){
            $("#deliver-calle").html("");
            $("#deliver-calle").append($("#checkout-calle").val());
        });
        $('#checkout-colonia').on('input',function(e){
            $("#deliver-colonia").html("");
            $("#deliver-colonia").append($("#checkout-colonia").val());
        });
    });
  </script>
@endsection