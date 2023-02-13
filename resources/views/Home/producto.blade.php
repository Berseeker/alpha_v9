@extends('layouts.web')

@section('page-styles')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/nouislider.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-sliders.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommercet.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
<link rel="stylesheet" href="{{ asset('css/home/second_style.css') }}">
<link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
<link rel="stylesheet" href="{{ asset('css/old/owl-carousel/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/old/owl-carousel/owl.theme.default.min.css') }}">
@endsection

    
@section('content')

<div style="margin-top: 60px;background-color:white;">
    <section>
        <h4 class="title-category">- Detalles -</h4>
        <div class="divider-custom" style="color: #AADD35;">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <img src="{{ asset('imgs/logos/alpha_icon.png') }}" alt="" class="alpha_icon">
            </div>
            <div class="divider-custom-line"></div>
        </div>
    </section>
    <!-- Ecommerce Products Starts -->
<section id="ecommerce-products">
    <div class="row" style="margin:0px;padding:10px;">
        <div class="col-12 col-sm-6 col-md-5">
            <div id="box-img">
                <div class="fotorama" data-nav="thumbs">
                    @if( $producto->images != NULL)
                        @foreach (json_decode($producto->images) as $img)
                            @php
                                $image = $img;
                                if(!Str::contains($img,['https','http']))
                                {
                                    $img = asset('storage/') . $img;
                                }
                                $imgCont = 0;
                            @endphp
    
                            <img src="{{ $image }}" alt='{{$producto->nombre}}'data-zoom-image="{{ $image }}" id="img_{{$imgCont}}" />
             
                            
                            @php
                                $imgCont++;
                            @endphp
                        @endforeach
                    @else
                        <img src="{{ asset('imgs/no_disp.png') }}" alt="Imagen no Encontrado">
                    @endif
                    
                </div>

            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-7">
            <div id="product-descripction">
                <h4> {{ $producto->nombre ?? 'Desconocido'}}</h4>
                <span><small>By <a href="">AlphaPromos</a></small></span>
                <ul class="unstyled-list list-inline" style="display: flex;">
                    <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                    <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                    <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                    <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                    @php
                        $star = 'fa-star-half-stroke';
                        $rand = rand(1,3);
                        if($rand == 1)
                            $star = 'fa-star';

                    @endphp
                    <li class="ratings-list-item"><i class="fa-solid {{$star}} gold-s"></i></li>
                </ul>
            </div>
            <div id="ficha-tecnica">
                <h4>Especificaciones</h4>
                <p class="detail-product" style="margin-bottom: 20px;">{{ $producto->descripcion }}</p>
                @php
                    if($producto->area_impresion != NULL){                  
                        echo '<p class="detail-product"><i class="fas fa-chart-area" style="margin-right:10px;"></i>Area de Impresión: '.$producto->area_impresion.' </p>';
                    }else{
                        echo '<p class="detail-product"><i class="fas fa-chart-area" style="margin-right:10px;"></i>Area de Impresión: No Especificado. </p>';
                    }
                    $printing_methods = '';
                    $cont = 0;
                    
                    foreach ($metodos_impresion as $printing) {
                        if ($cont > 0) {
                            $printing_methods = $printing_methods . ', ' . $printing;
                        } else {
                            $printing_methods = $printing;
                        }
                        $cont++;
                    }
                @endphp
                <p class="detail-product"><i class="fas fa-fill-drip" style="margin-right:10px;"></i> Metodos de Impresión: {{ $printing_methods ?? 'No Especificado' }} </p>
                <p class="detail-product"> <i class="fas fa-hashtag" style="margin-right:10px;"></i> Piezas x Caja: {{ $producto->piezas_caja ?? 'No Especificado' }} </p>
                <p class="detail-product"> <i class="fas {{ $producto->categoria->icon ?? 'fa-question' }}" style="margin-right: 10px;"></i> Categoría: {{ $producto->subcategoria->nombre ?? 'Desconocido'}} </p>
            </div>
            <div id="product-colors">
                <h4>Colores Disponibles</h4>
                    <div class="custom-radios">
                        @if ($colores != NULL)
                            @foreach ($colores as $color)
                                @php
                                    if(strpos($color,' ')){
                                        $color = str_replace(' ','_',$color);
                                    }
                                @endphp     
                                <div>
                                    <input type="radio" id="{{trim($color)}}" name="color" value="{{ trim($color) }}" >
                                    <label for="color-{{ $count_color }}">
                                        <span data-toggle="tooltip" data-placement="top" title="{{ $color }}">
                                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/check-icn.svg" alt="Checked Icon" />
                                        </span>
                                    </label>
                                </div>
                                @php
                                    $count_color++;
                                @endphp
                            @endforeach
                        @endif 
                    </div>
                    <a href="#" class="btn btn-primary btn-cart" sdk ='{{$producto->SDK}}'>
                        <i class="fa-solid fa-cart-plus"></i>
                        <span class="add-to-cart">Agregar al Carrito</span>
                     </a>
                    <!--button class="item_add_cart info-product-cart">
                        <i class="fas fa-shopping-cart"></i> Agregar al Carrito
                    </button-->
                    <button class="btn add_detalle_producto info-product-cotizar btn-cart-add" sdk ='{{$producto->SDK}}' slug={{ Str::slug($producto->nombre.' '.$producto->SDK) }}>
                        <i class="fas fa-store"></i>Cotizar
                    </button>
            </div>
            
        </div>
        
    </div>

    <div class="features text-center">
        <div class="row">
        <div class="col-md-3">
            <div class="info">
            <div class="icon icon-info">
                <i class="fas fa-handshake" style="color: #255992;"></i>
            </div>
            <h4 class="info-title">Atención Eficaz </h4>
            <p>Atención personalizada, con asesorías para una inteligente selección, acorde a sus necesidades y presupuesto.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info">
            <div class="icon icon-info">
                <i class="material-icons" style="color: green;">verified_user</i>
            </div>
            <h4 class="info-title">Experiencia </h4>
            <p>Con más de 25 años en el mercado.  Hemos amalgamado la experiencia con las innovaciones del mundo actual.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info">
            <div class="icon icon-success">
                <i class="fas fa-truck" style="color:#00bcd4;"></i>
            </div>
            <h4 class="info-title">Flete Incluido</h4>
            <p>Envíos a todo México sin pago extra.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info">
            <div class="icon icon-rose">
                <i class="fas fa-bolt" style="color:red;"></i>
            </div>
            <h4 class="info-title">Pedidos Express</h4>
            <p>Entrega de 48-72 horas.</p>
            </div>
        </div>
        </div>
    </div>

    <div class="container productos_relacionados">
        <h4 class="title-category">- Productos Relacionados -</h4>
        <div class="divider-custom" style="color: #AADD35;">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <img src="{{ asset('imgs/logos/alpha_icon.png') }}" alt="" class="alpha_icon">
            </div>
            <div class="divider-custom-line"></div>
        </div>
        <div class="owl-carousel owl-theme">
            @foreach ($productos_relacionados as $producto)
                <div class="item">
                    @if( $producto->images != NULL)
                        @php
                            $image = json_decode($producto->images);
                            if(!Str::contains($image[0],['https','http']))
                            {
                                $img = Storage::url($image[0]);
                            }
                            $imgCont = 0;
                        @endphp
    
                        <img src="{{ $image[0] }}" alt='{{$producto->nombre}}'data-zoom-image="{{ $image[0] }}" id="img_{{$imgCont}}" /> 
                    @else
                        <img src="{{ asset('imgs/no_disp.png') }}" alt="Imagen no Encontrado">
                    @endif
                    <div>
                        <h4> {{ $producto->nombre ?? 'Desconocido'}}</h4>
                        <span><small>By <a href="">AlphaPromos</a></small></span>
                        <ul class="unstyled-list list-inline" style="display: block;">
                            <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                            <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                            <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                            <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                            @php
                                $star = 'fa-star-half-stroke';
                                $rand = rand(1,3);
                                if($rand == 1)
                                    $star = 'fa-star';

                            @endphp
                            <li class="ratings-list-item"><i class="fa-solid {{$star}} gold-s"></i></li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</section>

</div>


@endsection

@section('page-scripts')
<!-- Page js files -->
<script src="{{ asset('vendors/js/extensions/wNumb.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/nouislider.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('js/scripts/pages/app-ecom.js') }}"></script>
<script src="{{ asset('js/old/owl-carousel/owl.carousel.min.js') }}"></script>
<script type="text/javascript">
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
</script>
@endsection
