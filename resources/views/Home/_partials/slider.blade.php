<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')           
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>              
        @endif
    @endforeach
    <a href="https://heyzine.com/flip-book/5d45bf3aff.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/infancias.png') }}" class="w-100" alt=""> </a>
    <div class="item"> <img src="{{ asset('imgs/v3/slider/madres.png') }}" class="w-100" alt=""> </div>
</div>