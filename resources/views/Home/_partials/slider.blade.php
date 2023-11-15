<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>
        @endif
    @endforeach
    <a href="https://heyzine.com/flip-book/9cd14e0311.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/navidad.jpg') }}" class="w-100" alt="Mes Rosa"> </a>
    <!--a href="https://heyzine.com/flip-book/fb14a7cf0f.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/camarista.png') }}" class="w-100" alt="Verano"> </a-->
</div>
