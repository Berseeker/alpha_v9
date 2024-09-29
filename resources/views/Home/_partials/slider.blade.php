<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>
        @endif
    @endforeach
    <a href="https://heyzine.com/flip-book/e2df54f8c2.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/walfort.svg') }}" class="w-100" alt="Walfort"> </a>
    <a href="https://heyzine.com/flip-book/00dccdb856.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/dia_muertos.svg') }}" class="w-100" alt="Dia de Muertos"> </a>
    <a href="https://heyzine.com/flip-book/c36ad09ed9.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/camarista.png') }}" class="w-100" alt="Las camaristas"> </a>
    <a href="https://heyzine.com/flip-book/c3c74ac4e9.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/agendas_24.svg') }}" class="w-100" alt="Fiestas Patrias"> </a>
    <a href="https://heyzine.com/flip-book/c951ddce5b.html" target="_blank" class="item"> <img src="{{ asset('imgs/v3/slider/mes_rosa.svg') }}" class="w-100" alt="Mes Rosa"> </a>
    <a href="#" class="item"> <img src="{{ asset('imgs/v3/slider/general.jpg') }}" class="w-100" alt="AlphaPromos"> </a>
</div>
