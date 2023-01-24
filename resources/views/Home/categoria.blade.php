@extends('layouts.web')

@section('page-styles')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('css/v3/home/category.css') }}">
@endsection

    
@section('content')
<div class="container">
    <section id="categoria-header">
        <h3> <img src=" {{ asset('imgs/v3/logos/alpha.ico') }} " alt="AlphaPromos" id="alphaCateg"> {{ $categoria->nombre }} </h3>
    </section>
    <section id="categoria-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3"></div>
            <div class="col-xs-12 col-sm-12 col-md-9">
                <div class="row">
                    {{ $productos->links() }}
                    @foreach ($productos as $producto)
                        <div class="col-xs-12 col-md-4">
                            <div class="product-header">
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
                            <div class="product-body">
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
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@section('page-scripts')

@endsection
