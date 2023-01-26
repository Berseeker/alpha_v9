@extends('layouts.web')

@section('page-styles')
<!-- Page css files -->
<script src="https://unpkg.com/js-image-zoom@0.7.0/js-image-zoom.js" type="application/javascript"></script>
<link rel="stylesheet" href="{{ asset('css/v3/home/products.css') }}">
@endsection

    
@section('content')

<div class="container" id="product-page">
    <section class="header-product">
        <div class="divider-custom" style="color: #AADD35;">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <img src="{{ asset('imgs/v3/logos/alpha.ico') }}" alt="" class="alpha_icon">
            </div>
            <div class="divider-custom-line" style="margin-left: 1rem;"></div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                <div class="owl-carousel owl-theme product-gallery">
                    @php
                        $cont = 0;
                    @endphp
                    @foreach (json_decode($producto->images) as $img)
                        @php
                            if(!Str::contains($img,['https','http']))
                            {
                                $img = Storage::disk('doblevela_img')->url($img);
                            }
                        @endphp
                        <div class="item" style="position: relative;"><img src="{{ $img }}" id="product{{ $cont }}" class="imgP" alt="{{ $producto->name }}"></div>
                        @php
                            $cont++;
                        @endphp
                    @endforeach
                </div>
            </div>
            <div class="d-md col-md-12 col-lg-3">
                @for ($i = 0; $i < $cont; $i++)
                    <div id="previewImg{{$i}}" class="custom-n flag" style="width:300px;height:300px;margin-top:50px;"></div>
                @endfor 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                <div class="product-details pd-top-20">
                    <h5 class="subtitle mb-15">{{ $title }}</h5>
                    <p>{{ $producto->details }}</p>
                    <h5 class="subtitle mb-15">Detalles:</h5>
                    <p class="mb-5c"><span>Subcategoria:</span> {{ $categoria->subcategoria->nombre }}</p>
                    <p class="mb-5c"><span>Metodos de impresión:</span> {{ $metodos_impresion }} </p>
                    @if ($producto->printing_area != NULL)
                         <p><span>Área de impresión:</span> {{ $producto->printing_area }}</p>
                    @endif
                    <h5 class="subtitle mb-15">Caja</h5>
                    <p class="mb-5c"><span>Piezas x caja:</span> {{ $producto->box_pieces }} pzas.</p>
                    @if ($producto->material != NULL)
                         <p class="mb-5c"><span>Material:</span> {{ $producto->material }}</p>
                    @endif
                    @if ($producto->nw != NULL)
                         <p><span>Peso Neto:</span> {{ $producto->nw }}</p>
                    @endif
                    <h5 class="subtitle mb-15">Colores disponibles</h5>
                    @if ($colors != NULL)
                        <ul class="color-list">
                            @foreach ($colors as $color)
                                <li><div class="{{ $color }} color-product" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{ $color }}"></div></li>
                            @endforeach
                        </ul>
                    @endif
                </div> 
            </div>
        </div>
    </section>
    <section class="row" id="features-row">
        <div class="col-xs-12 col-sm-2 col-md-3 features">
            <i class="fa-solid fa-handshake" style="color: #255992"></i>
            <h4>Atencion Eficáz</h4>
            <p>Atención personalizada, con asesorías para una inteligente selección, acorde a sus necesidades y presupuesto.</p>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-3 features">
            <i class="fa-solid fa-shield" style="color: green;"></i>
            <h4>Experiencia</h4>
            <p>Con más de 25 años en el mercado. Hemos amalgamado la experiencia con las innovaciones del mundo actual.</p>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-3 features">
            <i class="fa-solid fa-truck-ramp-box" style="color: brown"></i>
            <h4>Flete Grátis</h4>
            <p>A todo México en pedidos grandes.</p>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-3 features">
            <i class="fa-solid fa-trophy" style="color:#ffd700;"></i>
            <h4>Confianza</h4>
            <p>Más de 200 compañías ya han confiado en nuestra experiencia.</p>
        </div>
    </section>

    <section style="margin-bottom: 30px;">
        <h4 style="text-align: center;margin-bottom:30px;margin-top:40px;">Productos relacionados</h4>
        <div class="owl-carousel owl-theme productos-relacionados">
            @foreach ($productos_relacionados as $item)
                @php
                    //dd($item->imgs);
                    $imagen = url('/imgs/no_disp.png');
                    if ($item->images != null) {

                        $img = json_decode($item->images);
                        if(!Str::contains($img[0],['https','http']))
                        {
                            $imagen = Storage::disk('doblevela_img')->url($img[0]);
                        } else {
                            $imagen = $img[0];
                        }
                    }
                @endphp
                <div class="item"> 
                    <a href="{{ url('/producto/'. Str::slug($item->name . " " . $item->code,'-')) }}">
                        <div class="header-pr"><img src="{{ $imagen }}" alt=""></div>
                        <div class="body-pr"><p>{{ $item->name }}</p></div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
</div>

@endsection

@section('page-scripts')
<script type="text/javascript">

$(document).ready(function(){

    $('.product-gallery').owlCarousel({
        items:1,
    });

    $('.productos-relacionados').owlCarousel({
        loop:true,
        nav:false,
        margin:10,
        responsiveClass:true,
        autoplay:true,
        autoplayTimeout:4000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:2
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        }
    });

    @php
        for ($i = 0; $i < $cont; $i++) {
            echo "imageZoom('product".$i."', 'previewImg".$i."');";
        }
    @endphp
});

function imageZoom(imgID, resultID) {
    var img, lens, result, cx, cy;
    img = document.getElementById(imgID);
    result = document.getElementById(resultID);
    /*create lens:*/
    lens = document.createElement("DIV");
    lens.setAttribute("class", "img-zoom-lens");
    /*insert lens:*/
    img.parentElement.insertBefore(lens, img);
    /*calculate the ratio between result DIV and lens:*/
    var styleWidth = result.style.width;
    var cwidth = styleWidth.slice(0,-2);
    var styleHeight = result.style.height;
    var cheight = styleHeight.slice(0,-2);
    //console.log(cwidth);
    //cx = result.offsetWidth / lens.offsetWidth;
    //cx = parseInt(styleWidth) / lens.offsetWidth;
    cx = 2.5;
    //cy = result.offsetHeight / lens.offsetHeight;
    //cy = parseInt(styleHeight) / lens.offsetHeight;
    cy = 2.5;
    /*set background properties for the result DIV:*/
    result.style.backgroundImage = "url('" + img.src + "')";
    if (img.width == 0 || img.height == 0) {
        result.style.backgroundSize = (1000) + "px " + (1000) + "px";
    } else {
        result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
    } 
    /*execute a function when someone moves the cursor over the image, or the lens:*/
    lens.addEventListener("mousemove", moveLens);
    img.addEventListener("mousemove", moveLens);
    /*and also for touch screens:*/
    lens.addEventListener("touchmove", moveLens);
    img.addEventListener("touchmove", moveLens);
    function moveLens(e) {
        $(".flag").css('display','none');
        var pos, x, y;
        /*prevent any other actions that may occur when moving over the image:*/
        e.preventDefault();
        /*get the cursor's x and y positions:*/
        pos = getCursorPos(e);
        /*calculate the position of the lens:*/
        x = pos.x - (lens.offsetWidth / 2);
        y = pos.y - (lens.offsetHeight / 2);
        /*prevent the lens from being positioned outside the image:*/
        if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
        if (x < 0) {x = 0;}
        if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
        if (y < 0) {y = 0;}
        /*set the position of the lens:*/
        lens.style.left = x + "px";
        lens.style.top = y + "px";
        /*display what the lens "sees":*/
        result.style.display = 'block';
        result.style.backgroundRepeat = 'no-repeat';
        result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
    }
    function getCursorPos(e) {
        var a, x = 0, y = 0;
        e = e || window.event;
        /*get the x and y positions of the image:*/
        a = img.getBoundingClientRect();
        /*calculate the cursor's x and y coordinates, relative to the image:*/
        x = e.pageX - a.left;
        y = e.pageY - a.top;
        /*consider any page scrolling:*/
        x = x - window.pageXOffset;
        y = y - window.pageYOffset;
        return {x : x, y : y};
    }
}
</script>
@endsection
