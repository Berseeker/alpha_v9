<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>
        @endif
    @endforeach
    <a href="https://heyzine.com/flip-book/c3c74ac4e9.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/agendas_24.svg') }}" class="w-100" alt="Agendas 2024"> </a>
    <a href="https://heyzine.com/flip-book/d346a36865.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/clases_24.svg') }}" class="w-100" alt="Regreso a Clases"> </a>
    <a href="#" class="item"> <img src="{{ asset('imgs/v3/slider/general.jpg') }}" class="w-100" alt="AlphaPromos"> </a>
</div>
