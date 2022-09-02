{{-- {!! Helper::applClasses() !!} --}}
@php
$configData = Helper::applClasses();
@endphp

@extends('layouts/home' )

@section('title', 'Alpha Displays')

@section('vendor-style')


    <link rel="stylesheet" type="text/css" href="{{ asset('css/home/fancy_box.css') }}" />
    <!-- 1. Add latest jQuery and fancybox files -->

	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
	<style>
        .mobile-row{
            margin-left: -15px;
            margin-right: -15px;
        }

        .mobile-menu{
            display: none;
        }

        .desktop-menu{
            display: inline-flex;
        }


        @media(max-width: 500px){
            .mobile-row{
                margin-left: 0px;
                margin-right: 0px;
            }

            .mobile-menu{
                display: block;
            }

            .desktop-menu{
                display: none;
            }
        }
    </style>

@endsection

@section('content')

	<div class="display-header" style="margin-top: 100px;">
		<h2 style="text-align: center;margin-top:30px;margin-bottom:30px;">Alpha Displays</h2>
		<p>Ponemos a tus órdenes nuestro servicio de diseño y armado de stands para tus expos, convenciones o eventos sociales con personal calificado y precios 
			accesibles, solicita cotización.</p>
	</div>

	<div class="row" style="padding: 15px;">
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" data-caption="Caption for single image"  href="{{ asset('imgs/displays/danone.jpg') }}"><img src="{{ asset('imgs/displays/danone.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Grupo Danone</p>
		</div>
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/cougar_asus.jpg') }}"><img src="{{ asset('imgs/displays/cougar_asus.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Asus Gaming</p>
		</div>
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/aiko_cells.jpg') }}"><img src="{{ asset('imgs/displays/aiko_cells.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Aiko Cells</p>
		</div>
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/disk_display.jpg') }}"><img src="{{ asset('imgs/displays/disk_display.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Display Disk Evento</p>
		</div>
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/alinta.jpg') }}"><img src="{{ asset('imgs/displays/alinta.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Grupo Alinta</p>
		</div>
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/cdc_group.jpg') }}"><img src="{{ asset('imgs/displays/cdc_group.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Grupo CDC</p>
		</div>
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/clorox_2.jpg') }}"><img src="{{ asset('imgs/displays/clorox_2.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Grupo Clorox</p>
		</div>
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/got.jpg') }}"><img src="{{ asset('imgs/displays/got.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Serie GOT</p>
		</div>

		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/eas_system.jpg') }}"><img src="{{ asset('imgs/displays/eas_system.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand EAS System</p>
		</div>
		
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/fxm.jpg') }}"><img src="{{ asset('imgs/displays/fxm.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Grupo FXM</p>
		</div>

		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/innova_market.jpg') }}"><img src="{{ asset('imgs/displays/innova_market.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Innova Market</p>
		</div>
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/kamfri.jpg') }}"><img src="{{ asset('imgs/displays/kamfri.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Grupo Kamfri</p>
		</div>
		<div class="col-3 grid-box">
			<a data-fancybox="gallery" href="{{ asset('imgs/displays/kemin.jpg') }}"><img src="{{ asset('imgs/displays/kemin.jpg') }}" class="img-fluid"></a>
			<p class="fancy_text">Stand Grupo Kemin</p>
		</div>

	</div>

                   

@endsection

@section('page-script')
    <!-- Scripts Draggable -->
    <!--script src="{{ asset('js/home/services/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/home/services/charming.min.js') }}"></script>
    <script src="{{ asset('js/home/services/bezier-easing.min.js') }}"></script>
    <script src="{{ asset('js/home/services/TweenMax.min.js') }}"></script>
	<script src="{{ asset('js/home/display.js') }}"></script-->
@endsection
