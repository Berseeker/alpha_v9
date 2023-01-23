<div class="swiper">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        @foreach ($imagenes as $imagen)
            @if ($imagen->seccion == 'home_slider')           
                <a href="{{ ($imagen->pdf == null) ? '#' : Storage::url($imagen->pdf) }}" target="{{ ($imagen->pdf == null) ? '' : '_blank'}}" class="swiper-slide"><img src="{{ Storage::url($imagen->path) }}" alt="" height="600px;" class="customImgSilder"></a>              
            @endif
        @endforeach
        <div class="swiper-slide"> <img src="{{ asset('imgs/v3/slider/new_year.png') }}" class="w-100" alt=""> </div>
        <div class="swiper-slide"> <img src="{{ asset('imgs/v3/slider/template_banner.jpeg') }}" class="w-100" alt=""> </div>
        <div class="swiper-slide"> <img src="{{ asset('imgs/v3/slider/template_banner_2.jpeg') }}" class="w-100" alt=""> </div>
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>
    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>