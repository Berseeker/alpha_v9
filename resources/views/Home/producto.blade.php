@extends('layouts.web')

@section('page-styles')
<!-- Page css files -->
<script src="https://unpkg.com/js-image-zoom@0.7.0/js-image-zoom.js" type="application/javascript"></script>
<link rel="stylesheet" href="{{ asset('css/v3/home/item.css') }}">
@endsection

    
@section('content')

<div class="container">
    <section class="header-product">
        <h4>{{ $title }}</h4>
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

                <div style="position: relative">
                    <img src="{{ asset('imgs/v3/clientes/marriot_logo 2.webp') }}" id="test" style="width: 300px;height:300px" alt="">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                @for ($i = 0; $i < $cont; $i++)
                    <div id="previewImg{{$i}}" class="custom-n" style="width:300px;height:300px;"></div>
                @endfor 
            </div>
        </div>
    </section>
</div>

@endsection

@section('page-scripts')
<script type="text/javascript">
    $('.product-gallery').owlCarousel({
        items:1,
    });

    $(document).ready(function(){

        @php
            for ($i = 0; $i < $cont; $i++) {
                echo "imageZoom('product".$i."', 'previewImg".$i."');";
            }
        @endphp

        

        //new ImageZoom(document.getElementById('test'), options1);
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
        console.log('offsetWidth: '+result.width);
        console.log('offsetHeight: '+result.offsetHeight);
        cx = result.offsetWidth / lens.offsetWidth;
        cy = result.offsetHeight / lens.offsetHeight;
        /*set background properties for the result DIV:*/
        result.style.backgroundImage = "url('" + img.src + "')";
        result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
        /*execute a function when someone moves the cursor over the image, or the lens:*/
        lens.addEventListener("mousemove", moveLens);
        img.addEventListener("mousemove", moveLens);
        /*and also for touch screens:*/
        lens.addEventListener("touchmove", moveLens);
        img.addEventListener("touchmove", moveLens);
        function moveLens(e) {
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
            //result.style.backgroundPosition = "-" + (x) + "px -" + (y) + "px";
            result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
            /*console.log("-" + (x * cx) + "px -" + (y * cy) + "px");
            console.log("x: " + x);
            console.log("cx: " + cx);
            console.log("y: " + y);
            console.log("cy: " + cy);*/
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
