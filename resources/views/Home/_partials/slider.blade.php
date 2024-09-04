<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>
        @endif
    @endforeach
    <a href="https://heyzine.com/flip-book/8c1a0e5788.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/mes_patrio.svg') }}" class="w-100" alt="Fiestas Patrias"> </a>
    <a href="https://heyzine.com/flip-book/c951ddce5b.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/mes_rosa.svg') }}" class="w-100" alt="Mes Rosa"> </a>
    <a href="#" class="item"> <img src="{{ asset('imgs/v3/slider/general.jpg') }}" class="w-100" alt="AlphaPromos"> </a>
</div>
