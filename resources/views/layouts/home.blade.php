@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
{{-- {!! Helper::applClasses() !!} --}}
@php
$configData = Helper::applClasses();
@endphp
<html lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
    data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - AlphaPromos</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/favicon.ico') }}">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/8d420a663d.js" crossorigin="anonymous"></script>
    <!--script src="https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js" ></script-->
    <script src="{{ asset('js/home/jquery-slick.min.js') }}" ></script>
    <script src="{{ asset('js/home/TweenMax.min.js') }}" ></script>
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.2/TweenMax.min.js" ></script-->
    
    <link rel="stylesheet" href="{{ asset('fonts/feather/iconfont.css') }}">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/home/index_main.css') }}">

    <link rel="stylesheet" href="{{ asset('css/home/slick.css') }}">
    <!--link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css"-->
    <link rel="stylesheet" href="{{ asset('css/home/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/hover.css') }}">

    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/-->
    <link rel="stylesheet" href="{{ asset('css/home/stack_motion/animate.css') }}">
    <script src="{{asset('js/home/stack_motion/anime.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>document.documentElement.className="js";var supportsCssVars=function(){var e,t=document.createElement("style");return t.innerHTML="root: { --tmp-var: bold; }",document.head.appendChild(t),e=!!(window.CSS&&window.CSS.supports&&window.CSS.supports("font-weight","var(--tmp-var)")),t.parentNode.removeChild(t),e};supportsCssVars()||alert("Please view this demo in a modern browser that supports CSS Variables.");</script>
    

    @yield('vendor-style')




</head>



<body class=" vertical-layout vertical-menu-modern 1-column {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{($configData['theme'] === 'light') ? '' : $configData['theme'] }}"
    data-menu="vertical-menu-modern" data-col="1-column" data-layout="{{ $configData['theme'] }}">

    <div id="app">

        @include('menu.index')
        <div class="{{ $pageConfigs['bodyClass'] }} layout-top">   
            
            {{-- Include Page Content --}}
            @yield('content')     
        </div>
        @include('_partials.footer')
    </div>


</body>



@yield('page-script')



</html>