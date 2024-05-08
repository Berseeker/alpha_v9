<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>
        @endif
    @endforeach
    <a href="https://heyzine.com/flip-book/09553f0e61.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/padre.jpeg') }}" class="w-100" alt="Dial del Padre"> </a>
</div>
