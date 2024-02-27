<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>
        @endif
    @endforeach
    <a href="https://heyzine.com/flip-book/9543825ea8.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/march_women.jpg') }}" class="w-100" alt="8M"> </a>
    <!--a href="https://heyzine.com/flip-book/b3c8f4cce4.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/amor.jpeg') }}" class="w-100" alt="14 de Febrero"> </a-->
</div>
