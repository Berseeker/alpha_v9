<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>
        @endif
    @endforeach
    <a href="https://heyzine.com/flip-book/1d7fcab28d.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/clases.png') }}" class="w-100" alt="Regreso a Clases"> </a>
    <a href="https://heyzine.com/flip-book/46273dccdb.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/verano.png') }}" class="w-100" alt="Verano"> </a>
    <!--a href="https://heyzine.com/flip-book/82df5e58c1.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/docente.jpg') }}" class="w-100" alt="Dia del Docente"> </a>
    <a href="https://heyzine.com/flip-book/3235a7e578.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/madres.png') }}" class="w-100" alt="Dia de las madres"> </a-->
</div>
