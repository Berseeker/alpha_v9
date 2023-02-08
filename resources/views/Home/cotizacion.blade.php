@extends('layouts/web')

@section('title', 'Cotizacion')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/v3/home/cart_.css') }}">
    <link rel="stylesheet" href="{{ asset('css/v3/intel-input/intlTelInput.css') }}">
    <script src="{{ asset('js/v3/intel-input/intlTelInput.js') }}"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection


@section('content')
    <div class="container" id="cart-container">
        <form id="signUpForm" action="#!">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
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
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
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
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
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
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    @if ($total_productos > 0)
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
                                            <input type="number" class="form-control" name="noPzas[]" placeholder="Numero de piezas">  
                                        </div>
                                        <div class="mrb-5">
                                            <select class="form-select" name="printing_methods[]">
                                                @foreach (json_decode($producto->printing_methods) as $printing)
                                                    <option value="{{ $printing }}"> {{ $printing }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mrb-5">
                                            <input type="text" class="form-control" name="color[]" placeholder="Color deseado">  
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
                        @endforeach
                    @else
                        <div class="margin-top: 50px;" style="background-color: white;">
                            <img src="{{ asset('imgs/v3/logos/empty-cart.png') }}" alt="Carrito Vacio" style="display: block;margin:0 auto;width:500px;">
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                    <div class="address-box row">
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mb-3">
                                <label for="name" class="form-label blockC">Nombre(s)</label>
                                <input type="text" class="form-control widthC" id="name" name="name" placeholder="John">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mb-3">
                                <label for="lastname" class="form-label blockC">Apellido(s)</label>
                                <input type="text" class="form-control widthC" id="lastname" name="lastname" placeholder="Doe">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mb-3">
                                <label for="email" class="form-label blockC">Email</label>
                                <input type="email" class="form-control widthC" id="email" name="email" placeholder="name@example.com">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="phone" class="form-label blockC">Teléfono</label>
                                <input type="tel" class="form-control" name="phone" id="phone"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="pais" class="form-label blockC">País</label>
                                <input type="text" class="form-control widthC" name="pais" id="pais"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="ciudad" class="form-label blockC">Ciudad</label>
                                <input type="text" class="form-control widthC" name="ciudad" id="ciudad"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="cp" class="form-label blockC">Código Postal</label>
                                <input type="text" class="form-control widthC" name="cp" id="cp"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="mrb-5">
                                <label for="no_exterior" class="form-label blockC">Nº Exterior</label>
                                <input type="text" class="form-control widthC" name="no_exterior" id="no_exterior"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="mrb-5">
                                <label for="calle" class="form-label blockC">Dirección</label>
                                <input type="text" class="form-control widthC" name="calle" id="calle" style="width: 100%;"> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                    <div class="files-box row">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="mrb-5">
                                <label for="comentarios" class="form-label blockC">Comentarios</label>
                                <textarea name="comentarios" class="form-control" id="comentarios" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="mrb-5">
                                <div class="dropzone" id="dropzone">
                                </div>
                            </div>
                        </div>
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
    geoIpLookup: function(success, failure) {
        $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "us";
        success(countryCode);
        });
    },
});

Dropzone.autoDiscover = false;

// Dropzone class:
var myDropzone = new Dropzone("div#dropzone", { 
    url: "/file/post", 
    autoProcessQueue: false,
    uploadMultiple: true,
    addRemoveLinks: true
});

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