@extends('layouts/web')

@section('title', 'Cotizacion')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/v3/home/cart_.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v3/intel-input/intlTelInput.css') }}">
    <script src="{{ asset('js/v3/intel-input/intlTelInput.js') }}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!--link rel="stylesheet" href="/resources/demos/style.css"-->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@endsection


@section('content')
    <div class="container" id="cart-container">
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
        <form id="signUpForm" enctype="multipart/form-data" action="{{ route('home.store.cotizacion') }}" method="POST">
            @csrf
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="products" aria-selected="true">
                        <div class="btn-tab">
                            <i class="fa-solid fa-cart-shopping mr-10 mt-10"></i>
                            <div>
                                <p>Carrito</p>
                                <span>Productos de tu canasta</span>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-10" style="font-size: 15px;"></i>
                        </div>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">
                        <div class="btn-tab">
                            <i class="fa-solid fa-location-dot mr-10 mt-10"></i>
                            <div>
                                <p>Dirección</p>
                                <span>Ingresa tu domicilio</span>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-10" style="font-size: 15px;"></i>
                        </div>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="submit-tab" data-bs-toggle="tab" data-bs-target="#submit" type="button" role="tab" aria-controls="submit" aria-selected="false">
                        <div class="btn-tab">
                            <i class="fa-solid fa-basket-shopping mr-10 mt-10"></i>
                            <div>
                                <p>Cotiza</p>
                                <span>Cotiza tus productos</span>
                            </div>
                        </div>
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="hold-cart">
                <div class="tab-pane fade show active" id="products" role="tabpanel" aria-labelledby="products-tab" tabindex="0">
                    @if ($total_productos > 0)
                        @php
                            $indx = 0;
                        @endphp
                        @foreach ($productos as $producto)
                            <div class="show-product row" id="cart-{{ $producto->id }}" sdk="{{ $producto->code }}">
                                <div class="col-xs-12 col-md-4 col-lg-4 d-flex justify-content-center align-items-center">
                                    <img src="{{ $producto->imagen }}" class="imgProductCart" alt=" {{ $producto->name }}">
                                </div>
                                <div class="col-xs-12 col-md-4 col-lg-5">
                                    <div class="detailsProductCart">
                                        <p class="mrb-5"> {{ $producto->name }} </p>
                                        <p class="mrb-5 category-cart"> {{ $producto->subcategoria->nombre }} </p>
                                        <ul class="rateProductCart">
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            @php
                                                $random = rand(1, 3);
                                                $star = "";
                                                if ($random == 1) {
                                                    $star = 'fa-solid fa-star-half-stroke';
                                                }

                                                if ($random == 2) {
                                                    $star = 'fa-solid fa-star';
                                                }

                                                if ($random == 3) {
                                                    $star = 'fa-regular fa-star';
                                                }
                                            @endphp
                                            <li><i class="{{ $star }}"></i></li>
                                        </ul>
                                        <div class="mrb-5">
                                            <input type="number" class="form-control" name="noPzas[]" placeholder="Numero de piezas*" value="{{ old('noPzas')[$indx] ?? '' }}">  
                                            <input type="hidden" class="form-control" name="producto_id[]" value="{{ $producto->id }}">  
                                        </div>
                                        <div class="mrb-5">
                                            <select class="form-select" name="printing_methods[]">
                                                @foreach (json_decode($producto->printing_methods) as $printing)
                                                    <option value="{{ $printing }}"> {{ $printing }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mrb-5">
                                            <p style="font-size: 11px;margin-bottom:0px;margin-top:5px;font-weight:lighter;padding-left:10px;">Si es mas de un color, separar con coma</p>
                                            <input type="text" class="form-control" name="pantone[]" placeholder="Color deseado" value="{{ old('pantone')[$indx] ?? '' }}">  
                                        </div>
                                        <div class="mrb-5">
                                            <input type="text" class="form-control" name="no_ink[]" placeholder="Número de tintas" value="{{ old('no_ink')[$indx] ?? '' }}">  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-lg-3 d-flex align-items-center">
                                    <ul class="" style="list-style: none;padding-left:0px;">
                                        <li class="mb-15"><img src="{{ asset('imgs/v3/logos/alpha.png') }}" alt="" style="width: 30px;display:block;margin:0px auto;"></li>
                                        <li class="mb-15"><span>Cotización gratis</span></li>
                                        <li class="d-flex justify-content-center"><button class="btn remove-cart" onclick="deleteCart('cart-{{ $producto->id }}')"><i class="fa-solid fa-xmark mr-10"></i>Quitar</button></li>
                                    </ul>
                                </div>
                            </div>
                            @php
                                $indx++;
                            @endphp
                        @endforeach
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-alpha" onclick="activateTab('details')">Siguiente<i class="fa-solid fa-chevron-right ml-10"></i></a>
                        </div>
                    @else
                        <div class="margin-top: 50px;" style="background-color: white;">
                            <img src="{{ asset('imgs/v3/logos/empty-cart.png') }}" alt="Carrito Vacio" style="display: block;margin:0 auto;width:500px;">
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab" tabindex="0">
                    <div class="address-box row">
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mb-3">
                                <label for="name" class="form-label blockC">Nombre(s)</label>
                                <input type="text" class="form-control widthC" id="name" name="name" placeholder="John" value="{{ old('name') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mb-3">
                                <label for="lastname" class="form-label blockC">Apellido(s)</label>
                                <input type="text" class="form-control widthC" id="lastname" name="lastname" placeholder="Doe" value="{{ old('lastname') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mb-3">
                                <label for="email" class="form-label blockC">Email</label>
                                <input type="email" class="form-control widthC" id="email" name="email" placeholder="name@example.com" value="{{ old('email') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="phone" class="form-label blockC">Teléfono</label>
                                <input type="tel" class="form-control" name="phone" id="phone" value="{{ old('phone') ?? '' }}"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="pais" class="form-label blockC">País</label>
                                <input type="text" class="form-control widthC" name="country" id="pais" value="{{ old('country') ?? '' }}"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="estado" class="form-label blockC">Estado</label>
                                <input type="text" class="form-control widthC" name="state" id="estado" value="{{ old('state') ?? '' }}"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="ciudad" class="form-label blockC">Ciudad</label>
                                <input type="text" class="form-control widthC" name="city" id="ciudad" value="{{ old('city') ?? '' }}"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="cp" class="form-label blockC">Código Postal</label>
                                <input type="text" class="form-control widthC" name="cp" id="cp" value="{{ old('cp') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="no_exterior" class="form-label blockC">Nº Exterior</label>
                                <input type="text" class="form-control widthC" name="no_ext" id="no_exterior" value="{{ old('no_ext') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="no_exterior" class="form-label blockC">Fecha de entrega</label>
                                <input type="text" class="form-control widthC" name="deadline" id="datepicker" autocomplete="off" value="{{ old('deadline') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <div class="mrb-5">
                                <label for="calle" class="form-label blockC">Calle</label>
                                <input type="text" class="form-control widthC" name="address" id="calle" style="width: 100%;" value="{{ old('address') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-alpha mr-10" onclick="activateTab('products')"><i class="fa-solid fa-angle-left mr-10"></i>Atrás</a>
                        <a class="btn btn-alpha" onclick="activateTab('submit')">Siguiente<i class="fa-solid fa-chevron-right ml-10"></i></a>
                    </div>
                </div>
                <div class="tab-pane fade" id="submit" role="tabpanel" aria-labelledby="submit-tab" tabindex="0">
                    <div class="files-box row">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="mrb-5">
                                <label for="comentarios" class="form-label blockC">Comentarios</label>
                                <textarea name="comments" class="form-control" id="comentarios" cols="30" rows="30" style="width: 100%;resize:none;height:90px !important; margin-bottom:40px;">{{ old('comments') ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="mrb-5">
                                <label for="files" class="form-label blockC">Archivos</label>
                                <input type="file" name="files" class="form-control" id="files">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="mrb-5 mt-10">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="isWhatsApp" id="isWhatsApp">
                                    <label class="form-check-label" for="isWhatsApp">El teléfono que nos proporcionas tiene WhatsApp?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-alpha mr-10" onclick="activateTab('details')"><i class="fa-solid fa-angle-left mr-10"></i>Atrás</a>
                        <button type="submit" class="btn btn-cart"><i class="fa-solid fa-cart-plus mr-10"></i>Cotizar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('page-scripts')
<script type="text/javascript">
var input = document.querySelector("#phone");
window.intlTelInput(input, {
    // any initialisation options go here
    utilsScript: "/js/v3/intel-input/utils.js",
    initialCountry: "auto",
    formatOnDisplay: true,
    hiddenInput: 'fullNumber',
    separateDialCode: true,
    geoIpLookup: function(success, failure) {
        $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "us";
        success(countryCode);
        });
    },
});
 
$( function() {
    $( "#datepicker" ).datepicker({ 
        dateFormat: 'yy-mm-dd' 
    });
});


  
function activateTab(target) {
    const triggerEl = document.querySelector('#myTab button[data-bs-target="#'+ target +'"]')
    bootstrap.Tab.getOrCreateInstance(triggerEl).show() // Select tab by name
}

</script>
<script type="text/javascript">

function deleteCart(id)
{
    //DELETE ITEM FROM COOKIE
    var items = JSON.parse(Cookies.get('carrito_cotizaciones'));
    var sdk = $("#" + id).attr('sdk');
    items = jQuery.grep(items, function(value) {
        return value != sdk;
    });
    var value = JSON.stringify(items);
    Cookies.set('carrito_cotizaciones',value,{ expires: 2 });
    var cont = items.length;
    $("#cart-number").css('display','block');
    $("#cart-number").html('');
    $("#cart-number").html(cont);
    $('.remove-cart-warning').css('display','inline-block');
    $(".remove-cart-warning").fadeOut(10000);
    $('#' + id).css('display','none');
}
</script>


@endsection