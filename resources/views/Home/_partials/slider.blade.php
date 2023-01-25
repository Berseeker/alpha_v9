<div class="owl-carousel owl-theme home-slider">

    <!-- Slides -->
    @foreach ($imagenes as $imagen)
        @if ($imagen->seccion == 'home_slider')           
            <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="item"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>              
        @endif
    @endforeach
    <div class="item"> <img src="{{ asset('imgs/v3/slider/template_banner.jpeg') }}" class="w-100" alt=""> </div>
    <div class="item"> <img src="{{ asset('imgs/v3/slider/template_banner_2.jpeg') }}" class="w-100" alt=""> </div>
</div>