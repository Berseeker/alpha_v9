<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>
        @endif
    @endforeach
    <a href="https://heyzine.com/flip-book/1fec8a191c.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/padre.jpg') }}" class="w-100" alt="Dia del Padre"> </a>
    <a href="https://heyzine.com/flip-book/3235a7e578.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/madres.png') }}" class="w-100" alt="Dia de las madres"> </a>
</div>
