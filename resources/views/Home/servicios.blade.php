{{-- {!! Helper::applClasses() !!} --}}
@php
$configData = Helper::applClasses();
@endphp

@extends('layouts/home' )

@section('title', 'Servicios')

@section('vendor-style')
    <!--   Estilos Draggable --> 
    <link rel="stylesheet" href="https://use.typekit.net/ugp0unb.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home/services/base.css') }}" />
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

    <main>
        <div class="frame">
            <!--div class="frame__title-wrap">
                <h1 class="frame__title">Animated Image Columns</h1>
            </div>
            <div class="frame__links">
                <a href="https://tympanus.net/Tutorials/underwater-navigation/">Previous demo</a>
                <a href="https://tympanus.net/codrops/?p=40486">Article</a>
                <a href="https://github.com/codrops/AnimatedImageColumns/">Github</a>
            </div-->
        </div>
        <div class="content content--second">
            <article class="item">
                <div class="item__img" style="background-image: url('/imgs/services/serigrafia.png')"></div>
                <div class="item__content">
                    <a class="item__content-back">regresar</a>
                    <h2 class="item__content-title">Serigrafía</h2>
                    <h3 class="item__content-subtitle">by AlphaPromos</h3>
                    <div class="item__content-text">
                        <p>Método de reproducción de imágenes y textos casi sobre cualquier material (como textiles, plásticos, piel, materiales sintéticos, metales y papel), consiste en transferir una tinta a través de una malla tensada en un marco. El paso de la tinta se bloquea en las áreas donde no habrá imagen mediante una emulsión o barniz, quedando libre la zona donde pasará la tinta. Este sistema de impresión puede ser repetida cientos y hasta miles de veces sin perder resolución con la misma imagen. Es recomendable para imprimir en tamaños chicos medianos y grandes. Todo el proceso es manual (casi siempre). Por su naturaleza, a veces el secado de las tintas tiende a ser un poco lento dependiendo tanto de la superficie, el material en que se imprima, así como de la cantidad de tintas que se apliquen.</p>
                    </div>
                </div>
            </article>
            <article class="item">
                <div class="item__img" style="background-image: url('/imgs/services/tampografia.png')"></div>
                <div class="item__content">
                    <a class="item__content-back">regresar</a>
                    <h2 class="item__content-title">Tampografía</h2>
                    <h3 class="item__content-subtitle">by AlplhaPromos</h3>
                    <div class="item__content-text">
                        <p>Es un proceso de reproducción e impresión que consiste en una placa metálica o plástica, revestida de una emulsión fotosensible, donde se graba una imagen por un proceso químico, formando un grabado, esta placa es cubierta de tinta y barrida por una cuchilla, posteriormente un tampón de silicona presiona sobre el grabado de la placa recogiendo la tinta del grabado y transportándola sobre la pieza que será impresa por contacto. Éste sistema es actualmente muy utilizado para el marcaje de piezas industriales y publicidad, normalmente se aplica en espacios pequeños como plumas, llaveros, pelotas antiestress, etc. </p>
                    </div>
                </div>
            </article>
            <article class="item">
                <div class="item__img" style="background-image: url('/imgs/services/grabado_laser.png')"></div>
                <div class="item__content">
                    <a class="item__content-back">regresar</a>
                    <h2 class="item__content-title">Grabado láser</h2>
                    <h3 class="item__content-subtitle">by AlphaPromos</h3>
                    <div class="item__content-text">
                        <p>El grabado láser es un procedimiento que se usa para quitar, quemar o extraer el material de la superficie de un sólido mediante la irradiación de un rayo láser. Normalmente este sistema se usa en productos como piel, curpiel, metales etc. el tamaño a grabar es limitado, aproximadamente de 5 a 7 cm2 (para artículos pequeños) como llaveros, memorias usb, plumas metálicas, libretas recubiertas con materiales sintéticos. y algunos tipos de plástico o silicona.</p>
                    </div>
                </div>
            </article>
            <article class="item">
                <div class="item__img" style="background-image: url('/imgs/services/sublimacion.png')"></div>
                <div class="item__content">
                    <a class="item__content-back">regresar</a>
                    <h2 class="item__content-title">Sublimación</h2>
                    <h3 class="item__content-subtitle">by AlphaPromos</h3>
                    <div class="item__content-text">
                        <p>Es una técnica que utiliza calor para transferir una imagen a un medio a partir de una papel impregnado con tintas de cuatro (4) colores CMYK (Cyan, Magenta, Amarillo, y Negro), impresa por una impresora de INK JET especializada para sublimación, ya que usa mecanismos completamente distintos a los una impresora normal de ink jet. Está pensada para aplicaciones de color de alta calidad, como la fotografía profesional, no son recomendables para impresión de sólo textos y está limitada por los tamaños tanto de papelería comercial, como el área designada de los fabricantes de la impresoras en sí. Esta técnica es para ser impresa y transferida por medio de planchas, su uso es limitado para el tipo de materiales como textiles como playeras, termos y tazas con fondos claros normalmente. </p>
                    </div>
                </div>
            </article>
            <article class="item">
                <div class="item__img" style="background-image: url('/imgs/services/sand_blast.png')"></div>
                <div class="item__content">
                    <a class="item__content-back">regresar</a>
                    <h2 class="item__content-title">Sand Blast</h2>
                    <h3 class="item__content-subtitle">by AlphaPromos</h3>
                    <div class="item__content-text">
                        <p>Esta técnica de decoración y grabado se realiza a través de la erosión por medio de arena estrellada a través de una mecanismo que la recolecta y la expulsa a una alta velocidad al material que tiene un recubrimiento previamente adherido (normalmente en vinil) con una imagen descubierta. Una vez que la imagen se ha grabado entonces se retira el vinil. También se puede decorar con tintas manualmente antes de retirar el vinil. Esta técnica normalmente es usada para tazas de cerámica.</p>
                    </div>
                </div>
            </article>
            <article class="item">
                <div class="item__img" style="background-image: url('/imgs/services/vynil.png')"></div>
                <div class="item__content">
                    <a class="item__content-back">regresar</a>
                    <h2 class="item__content-title">Vinil Textil</h2>
                    <h3 class="item__content-subtitle">by AlphaPromos</h3>
                    <div class="item__content-text">
                        <p>Es la aplicación y planchado en calor de vinil recortado autoadherible de acuerdo a una figura o logotipo. Esta aplicación normalmente es usada en prendas textiles como playeras, gorras, mochilas o bolsas. Y más comúnmente cuando las prendas ya tienen una forma, pero carecen de una manera más cómoda de ser impresas en otras técnica. También cuando se le quiere dar un toque más brillante o con más textura a la figura o logotipo a ser impreso.</p>
                    </div>
                </div>
            </article>
            <article class="item">
                <div class="item__img" style="background-image: url('/imgs/services/gota_resina.png')"></div>
                <div class="item__content">
                    <a class="item__content-back">regresar</a>
                    <h2 class="item__content-title">Gota de Resina</h2>
                    <h3 class="item__content-subtitle">by AlphaPromos</h3>
                    <div class="item__content-text">
                        <p>Normalmente usada para proyectos especiales, en donde se imprimen gafetes ya sea personalizados o en serie y van protegidos con un material acrílico de resina. Este tipo de impresión y aplicación se usa para identificadores de personal como gafetes, llaveros o pines, por su naturaleza de fabricación o elaboración tiene un proceso especialmente lento.</p>
                    </div>
                </div>
            </article>
            <article class="item">
                <div class="item__img" style="background-image: url('/imgs/services/bordado.png')"></div>
                <div class="item__content">
                    <a class="item__content-back">regresar</a>
                    <h2 class="item__content-title">Bordado</h2>
                    <h3 class="item__content-subtitle">by AlphaPromos</h3>
                    <div class="item__content-text">
                        <p>El bordado es una técnica que se realiza sobre tela, mediante la acción de la aguja y el empleo de hilos. Actualmente, máquinas especiales realizan este tipo de bordados aplicándose sobre cualquier tipo de prendas y géneros textiles. Es posible bordar logos en gorras, camisetas, ropa de trabajo y en todos aquellos elementos que en su confección cuenten con tela.</p>
                    </div>
                </div>
            </article>
            <article class="item">
                <div class="item__img" style="background-image: url('/imgs/services/impresion_digital.png')"></div>
                <div class="item__content">
                    <a class="item__content-back">regresar</a>
                    <h2 class="item__content-title">Impresión Digital</h2>
                    <h3 class="item__content-subtitle">by AlphaPromos</h3>
                    <div class="item__content-text">
                        <p>Técnica de impresión por inyección, para productos planos y en 3D, se puede aplicar casi en cualquier material. Se marca el logotipo o imagen directamente en el producto utilizando la técnica de impresión digital y obteniendo una calidad extrema. Con esta técnica el dise?o se marca en cuatricromía y los detalles pueden estar mejor definidos. El marcaje es de gran precisión y es posible marcar varios colores o un simple texto.</p>
                    </div>
                </div>
            </article>
        </div>
        <div class="content content--first">
            <div class="content__move">
                <div class="columns">
                    <div class="column">
                        <div class="column__img" style="background-image:url('/imgs/services/sublimacion.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/grabado_laser.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/gota_resina.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/tampografia.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/serigrafia.png')"></div>
                        <!--div class="column__img" style="background-image:url('/imgs/services/grabado_laser.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/bordado.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/sand_blast.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/sublimacion.png')"></div-->
                    </div>
                    <div class="column column--bottom">
                        <div class="column__img" style="background-image:url('/imgs/services/tampografia.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/grabado_laser.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/vynil.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/gota_resina.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/tampografia.png')"></div>
                        <!--div class="column__img" style="background-image:url('/imgs/services/impresion_digital.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/sand_blast.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/tampografia.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/gota_resina.png')"></div-->
                    </div>
                    <div class="column">
                        <div class="column__img" style="background-image:url('/imgs/services/bordado.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/sand_blast.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/sublimacion.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/grabado_laser.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/serigrafia.png')"></div>
                        <!--div class="column__img" style="background-image:url('/imgs/services/tampografia.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/sublimacion.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/vynil.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/serigrafia.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/impresion_digital.png')"></div-->
                    </div>
                    <div class="column column--bottom">
                        <div class="column__img" style="background-image:url('/imgs/services/vynil.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/sublimacion.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/tampografia.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/bordado.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/sand_blast.png')"></div>
                        <!--div class="column__img" style="background-image:url('/imgs/services/grabado_laser.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/serigrafia.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/impresion_digital.png')"></div>
                        <div class="column__img" style="background-image:url('/imgs/services/vynil.png')"></div-->
                    </div>
                </div><!--/columns-->
                <nav class="menu">
                    <a class="menu__item">Serigrafía</a>
                    <a class="menu__item">Tampografía</a>
                    <a class="menu__item">Grabado Láser</a>
                    <a class="menu__item">Sublimación</a>
                    <a class="menu__item">Sand Blast</a>
                    <a class="menu__item">Vinil Textil</a>
                    <a class="menu__item">Gota de Resina</a>
                    <a class="menu__item">Bordado</a>
                    <a class="menu__item">Impresión Digital</a>
                </nav>
            </div><!--/content--move-->
        </div><!--/content-->
    </main>
    <div class="cursor">
        <div class="cursor__inner cursor__inner--circle"></div>
    </div>

@endsection

@section('page-script')
    <!-- Scripts Draggable -->
    <script src="{{ asset('js/home/services/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/home/services/charming.min.js') }}"></script>
    <script src="{{ asset('js/home/services/bezier-easing.min.js') }}"></script>
    <script src="{{ asset('js/home/services/TweenMax.min.js') }}"></script>
    <script src="{{ asset('js/home/services/demo.js') }}"></script>
@endsection
