<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>
        @endif
    @endforeach
    <a href="https://heyzine.com/flip-book/2c7d81ef12.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/lluvia.jpg') }}" class="w-100" alt="Dias Lluvios"> </a>
    <a href="https://heyzine.com/flip-book/0fe913e035.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/orgullo.jpg') }}" class="w-100" alt="Dial del Orgullo"> </a>
    <a href="#" class="item"> <img src="{{ asset('imgs/v3/slider/general.jpg') }}" class="w-100" alt="AlphaPromos"> </a>
</div>
