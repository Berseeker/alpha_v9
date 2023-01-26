@extends('layouts.web')

@section('page-styles')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('css/v3/home/category.css') }}">
@endsection

    
@section('content')
<div class="container">
    <section id="categoria-header">
        <h3> <img src=" {{ asset('imgs/v3/logos/alpha.ico') }} " alt="AlphaPromos" id="alphaCateg"> {{ $title }} </h3>
    </section>
    <section id="categoria-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                <div class="selector" data-margin-top="100">
                    <h5><i class="fa-solid fa-list-ul mr-10 alpha-color"></i>{{ $subcategoria->nombre }}</h5>
                    <ul class="list-categoria">
                        @foreach ($categoria->subcategorias as $subcategoria)
                            <li><a href="#">{{ $subcategoria->nombre }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-9">
                {{ $productos->links() }}
                <div class="row" style="margin-top: 20px;">
                    @foreach ($productos as $producto)
                        <div class="col-xs-12 col-md-12 col-lg-6 col-xl-4 mb-30">
                            <div class="shadowx">
                                <a href="{{ url('/producto/' . Str::slug($producto->name." ".$producto->code, '-')) }}" class="bg-producto br-16c">
                                    <div class="product-header pd-16c">
                                        @php
                                            $img = asset('imgs/v3/productos/no_disp.png');
                                            if($producto->images != null)
                                            {
                                                $img = json_decode($producto->images)[0];
                                                if(!Str::contains($img,['https','http']))
                                                {
                                                    $img = Storage::disk('doblevela_img')->url($img);
                                                }
                                            }
                                        @endphp 
                                        <img src="{{ $img }}" alt="{{ $producto->name }}">
                                    </div>
                                    <div class="product-body pd-16c">
                                        <p class="title alpha-color">{{ $producto->name }}</p>
                                        <ul>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            @php
                                                $random = rand(1, 3);
                                                $star = "";
                                                if ($random == 1) {
                                                    $star = 'fa-solid fa-star-half-stroke';
                                                }

                                                if ($random == 2) {
                                                    $star = 'fa-solid fa-star';
                                                }

                                                if ($random == 3) {
                                                    $star = 'fa-regular fa-star';
                                                }
                                            @endphp
                                            <li><i class="{{ $star }}"></i></li>
                                        </ul>
                                        <p class="description-item">{{ $producto->details }}</p>
                                        @php
                                            $colores = json_decode($producto->colors);
                                        @endphp
                                        <ul class="color-list">
                                            @foreach ($colores as $color)
                                                <li><div class="{{ $color }} color-product" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{ $color }}"></div></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </a>
                                <div class="product-footer row mr-0 ml-0">
                                    <div class="col-xs-12 col-sm-12 col-md-4 pd-0">
                                        <a href="" class="btn pd-0 d-flex align-items-center justify-content-center bg-w br-r0"><i class="fa-solid fa-info"></i>Detalles</a>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8 pd-0">
                                        <a href="" class="btn pd-0 d-flex align-items-center justify-content-center bg-alpha br-l0"><i class="fa-solid fa-cart-plus"></i>Agregar al carrito</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $productos->links() }}
            </div>
        </div>
    </section>
</div>
@endsection

@section('page-scripts')
<script src="{{ asset('js/v3/sticky/sticky.min.js') }}"></script>
<script type="text/javascript">
    var sticky = new Sticky('.selector');
</script>
@endsection
