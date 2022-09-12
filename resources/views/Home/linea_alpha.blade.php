{{-- {!! Helper::applClasses() !!} --}}
@php
$configData = Helper::applClasses();
@endphp

@extends('layouts/home' )

@section('title', 'Linea Alpha')

@section('vendor-style')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.4.0/css/lightgallery-bundle.min.css" integrity="sha512-91yJwfiGTCo9TM74ZzlAIAN4Eh5EWHpQJUfvo/XhpH6lzQtiRFkFRW1W+JSg4ch4XW3/xzh+dY4TOw/ILpavQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home/inline_gallery.css') }}" />
    <!-- 1. Add latest jQuery and fancybox files -->

@endsection

@section('content')

	<div class="display-header" style="margin-top: 100px;">
		<h2 style="text-align: center;margin-top:30px;margin-bottom:30px;">Alpha Displays</h2>
		<p>Ponemos a tus órdenes nuestro servicio de diseño y armado de stands para tus expos, convenciones o eventos sociales con personal calificado y precios 
			accesibles, solicita cotización.</p>
	</div>

	<div class="row" style="padding:0px;">
        <div class="col-xs-6 col-sm-5">
            <form action="{{ route('home.contacto') }}" method="POST">
                @csrf
                @if (session('success'))
                    <div class="alert alert-success" role="alert" style="width: 500px;display:block;margin:0px auto;text-align:center;margin-top:60px;padding:8px;">
                        <i class="fas fa-thumbs-up" style="margin-right: 10px;"></i> {{ session('success') }}
                    </div>
                @endif 
                @if($errors->any())
                    <div class="alert alert-danger" >
                        <ul style="list-style: none;">
                            @foreach($errors->all() as $key => $error)
                                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Ejemplo: John Doe">
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" class="form-control" name="email" placeholder="Ejemplo: johndoe@test.com">
                </div>
                <div class="form-group">
                    <label for="celular">Teléfono/Celular</label>
                    <input type="text" class="form-control" name="celular" placeholder="Ejemplo: johndoe@test.com">
                </div>
                <div class="form-group">
                    <label for="comentarios">Comentarios</label>
                    <textarea name="comentarios" class="form-control" cols="30" rows="10"></textarea>
                </div>

                <div class="form-group">
                    {!! htmlFormSnippet([
                        "theme" => "light",
                        "size" => "normal",
                        "tabindex" => "3",
                        "callback" => "callbackFunction",
                        "expired-callback" => "expiredCallbackFunction",
                        "error-callback" => "errorCallbackFunction",
                    ]) !!}
                </div>
               
                <div class="form-group">
                    <button type="submit" class="btn btn-primary me-1">Enviar</button>
                </div>
            </form>
        </div>
        <div class="col-xs-6 col-sm-7">
            <div id="inline-gallery-container" class="inline-gallery-container"></div>
        </div>
    </div>

@endsection

@section('page-script')
    <script type="module">
        import lightGallery from "https://cdn.skypack.dev/lightgallery@2.4.0";
        import lgZoom from "https://cdn.skypack.dev/lightgallery@2.4.0/plugins/zoom";
        import lgThumbnail from "https://cdn.skypack.dev/lightgallery@2.4.0/plugins/thumbnail";

        const $lgContainer = document.getElementById("inline-gallery-container");

        const inlineGallery = lightGallery($lgContainer, {
            container: $lgContainer,
            dynamic: true,
            // Turn off hash plugin in case if you are using it
            // as we don't want to change the url on slide change
            hash: false,
            // Do not allow users to close the gallery
            closable: false,
            // Add maximize icon to enlarge the gallery
            showMaximizeIcon: true,
            // Append caption inside the slide item
            // to apply some animation for the captions (Optional)
            appendSubHtmlTo: ".lg-item",
            // Delay slide transition to complete captions animations
            // before navigating to different slides (Optional)
            // You can find caption animation demo on the captions demo page
            slideDelay: 400,
            plugins: [lgZoom, lgThumbnail],
            dynamicEl: [
                {
                src:
                    "/imgs/hats/hat_1.jpeg",
                responsive:
                    "/imgs/hats/hat_1.jpeg",
                thumb:
                    "imgs/hats/hat_1.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_2.jpeg",
                responsive:
                    "/imgs/hats/hat_2.jpeg",
                thumb:
                    "imgs/hats/hat_2.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_3.jpeg",
                responsive:
                    "/imgs/hats/hat_3.jpeg",
                thumb:
                    "imgs/hats/hat_3.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_4.jpeg",
                responsive:
                    "/imgs/hats/hat_4.jpeg",
                thumb:
                    "imgs/hats/hat_4.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_5.jpeg",
                responsive:
                    "/imgs/hats/hat_5.jpeg",
                thumb:
                    "imgs/hats/hat_5.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_6.jpeg",
                responsive:
                    "/imgs/hats/hat_6.jpeg",
                thumb:
                    "imgs/hats/hat_6.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_7.jpeg",
                responsive:
                    "/imgs/hats/hat_7.jpeg",
                thumb:
                    "imgs/hats/hat_7.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_8.jpeg",
                responsive:
                    "/imgs/hats/hat_8.jpeg",
                thumb:
                    "imgs/hats/hat_8.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_9.jpeg",
                responsive:
                    "/imgs/hats/hat_9.jpeg",
                thumb:
                    "imgs/hats/hat_9.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_10.jpeg",
                responsive:
                    "/imgs/hats/hat_10.jpeg",
                thumb:
                    "imgs/hats/hat_10.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_11.jpeg",
                responsive:
                    "/imgs/hats/hat_11.jpeg",
                thumb:
                    "imgs/hats/hat_11.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_12.jpeg",
                responsive:
                    "/imgs/hats/hat_12.jpeg",
                thumb:
                    "imgs/hats/hat_12.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_13.jpeg",
                responsive:
                    "/imgs/hats/hat_13.jpeg",
                thumb:
                    "imgs/hats/hat_13.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_14.jpeg",
                responsive:
                    "/imgs/hats/hat_14.jpeg",
                thumb:
                    "imgs/hats/hat_14.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_15.jpeg",
                responsive:
                    "/imgs/hats/hat_15.jpeg",
                thumb:
                    "imgs/hats/hat_15.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_16.jpeg",
                responsive:
                    "/imgs/hats/hat_16.jpeg",
                thumb:
                    "imgs/hats/hat_16.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_17.jpeg",
                responsive:
                    "/imgs/hats/hat_17.jpeg",
                thumb:
                    "imgs/hats/hat_17.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_18.jpeg",
                responsive:
                    "/imgs/hats/hat_18.jpeg",
                thumb:
                    "imgs/hats/hat_18.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_19.jpeg",
                responsive:
                    "/imgs/hats/hat_19.jpeg",
                thumb:
                    "imgs/hats/hat_19.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_20.jpeg",
                responsive:
                    "/imgs/hats/hat_20.jpeg",
                thumb:
                    "imgs/hats/hat_20.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_21.jpeg",
                responsive:
                    "/imgs/hats/hat_21.jpeg",
                thumb:
                    "imgs/hats/hat_21.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_22.jpeg",
                responsive:
                    "/imgs/hats/hat_22.jpeg",
                thumb:
                    "imgs/hats/hat_22.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_23.jpeg",
                responsive:
                    "/imgs/hats/hat_23.jpeg",
                thumb:
                    "imgs/hats/hat_23.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_24.jpeg",
                responsive:
                    "/imgs/hats/hat_24.jpeg",
                thumb:
                    "imgs/hats/hat_24.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_25.jpeg",
                responsive:
                    "/imgs/hats/hat_25.jpeg",
                thumb:
                    "imgs/hats/hat_25.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_26.jpeg",
                responsive:
                    "/imgs/hats/hat_26.jpeg",
                thumb:
                    "imgs/hats/hat_26.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_27.jpeg",
                responsive:
                    "/imgs/hats/hat_27.jpeg",
                thumb:
                    "imgs/hats/hat_27.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_28.jpeg",
                responsive:
                    "/imgs/hats/hat_28.jpeg",
                thumb:
                    "imgs/hats/hat_28.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_29.jpeg",
                responsive:
                    "/imgs/hats/hat_29.jpeg",
                thumb:
                    "imgs/hats/hat_29.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_30.jpeg",
                responsive:
                    "/imgs/hats/hat_30.jpeg",
                thumb:
                    "imgs/hats/hat_30.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_31.jpeg",
                responsive:
                    "/imgs/hats/hat_31.jpeg",
                thumb:
                    "imgs/hats/hat_31.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_32.jpeg",
                responsive:
                    "/imgs/hats/hat_32.jpeg",
                thumb:
                    "imgs/hats/hat_32.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_33.jpeg",
                responsive:
                    "/imgs/hats/hat_33.jpeg",
                thumb:
                    "imgs/hats/hat_33.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_34.jpeg",
                responsive:
                    "/imgs/hats/hat_34.jpeg",
                thumb:
                    "imgs/hats/hat_34.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_35.jpeg",
                responsive:
                    "/imgs/hats/hat_35.jpeg",
                thumb:
                    "imgs/hats/hat_35.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_36.jpeg",
                responsive:
                    "/imgs/hats/hat_36.jpeg",
                thumb:
                    "imgs/hats/hat_36.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_37.jpeg",
                responsive:
                    "/imgs/hats/hat_37.jpeg",
                thumb:
                    "imgs/hats/hat_37.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                },
                {
                src:
                    "/imgs/hats/hat_38.jpeg",
                responsive:
                    "/imgs/hats/hat_38.jpeg",
                thumb:
                    "imgs/hats/hat_38.jpeg",
                subHtml: `<div class="lightGallery-captions">
                                <h4>Foto de <a href="https://alphapromos.mx">AlphaPromos</a></h4>
                                <p>Publicada en Septiembre 12, 2022</p>
                            </div>`
                }  
            ],

            // Completely optional
            // Adding as the codepen preview is usually smaller
            thumbWidth: 60,
            thumbHeight: "40px",
            thumbMargin: 4
        });

        setTimeout(() => {
            inlineGallery.openGallery();
        }, 200);

    </script>
@endsection
