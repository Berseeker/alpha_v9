@extends('layouts.web')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('css/home/new_style.css') }}">
@endsection

@section('content')
    @include('Home._partials.slider')



@endsection

@section('page-scripts')

<script type="text/javascript">
    const swiper = new Swiper('.swiper', {
        // Optional parameters
        loop: true,

        // If we need pagination
        pagination: {
          el: ".swiper-pagination",
          type: "progressbar",
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>

@endsection



