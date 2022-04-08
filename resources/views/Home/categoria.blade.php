@extends('layouts.web')

@section('page-styles')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/nouislider.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-sliders.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommercet.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
<link rel="stylesheet" href="{{ asset('css/home/categori.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home/home_web.css') }}">
@endsection

    
@section('content')
<!-- E-commerce Content Section Starts -->

<div class="app-content content ecommerce-application content-w">
    <section>
        <h4 class="title-category">- {{ $title }} -</h4>
        <div class="divider-custom" style="color: #AADD35;">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <img src="{{ asset('imgs/logos/alpha_icon.png') }}" alt="" class="alpha_icon">
            </div>
            <div class="divider-custom-line"></div>
        </div>
    </section>
    <div class="row">
        <div class="col-sm-3 col-md-2">
            @include('layouts.sidebar')
        </div>
        <div class="col-sm-9 col-md-10">

            <!-- E-commerce Search Bar Starts -->
            <section id="ecommerce-searchbar" class="ecommerce-searchbar">
                <div class="row mt-1">
                    <div class="col-sm-12 col-md-6">
                        <div class="search-results" style="text-align: left;"><i class="fa-solid fa-magnifying-glass" style="margin-right: 5px;color:#7367f0"></i>{{ $total }} productos encontrados</div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        @if($productos instanceof \Illuminate\Pagination\LengthAwarePaginator )
                            {{$productos->links()}}
                        @endif
                    </div>
                </div>
            </section>
            <!-- E-commerce Search Bar Ends -->
            
            <!-- E-commerce Products Starts -->
            <section id="ecommerce-products" class="grid-view row">
                @if ($productos->isEmpty())

                    <img src="{{ asset('imgs/logos/no_item.png') }}" alt="No hay productos que coincidan con tu busqueda" style="width: 350px;margin:0px auto;margin-bottom:20px;">
                    <h2 class="text-warning">No se encontraron productos relacionados <br> con tu búsqueda </h2>

                @else
                    @foreach ($productos as $producto)
                        <div class="col-sm-4 col-md-3">
                            <div class="card ecommerce-card">
                                <div class="item-img text-center">
                                    <a href="{{url('app/ecommerce/details')}}">
                                        @php
                                            $img = asset('imgs/no_disp.png');
                                            if($producto->images != null)
                                            {
                                                $img = json_decode($producto->images)[0];
                                                if(!Str::contains($img,['https','http']))
                                                {
                                                    $img = Storage::url($img);
                                                }
                                            }
                                        @endphp 
                                        <img
                                        class="img-fluid card-img-top"
                                        src="{{ $img }}"
                                        alt="img-placeholder"
                                    /></a>
                                </div>
                                <div class="card-body">
                                    <div class="item-wrapper">
                                        <div class="item-rating">
                                            <ul class="unstyled-list list-inline">
                                                <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                                                <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                                                <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                                                <li class="ratings-list-item"><i class="fa-solid fa-star gold-s"></i></i></li>
                                                @php
                                                    $star = 'fa-star-half-stroke';
                                                    $rand = rand(1,3);
                                                    if($rand == 1)
                                                        $star = 'fa-star';

                                                @endphp
                                                <li class="ratings-list-item"><i class="fa-solid {{$star}} gold-s"></i></li>
                                            </ul>
                                        </div>
                                        <div>
                                            <!--h6 class="item-price">$339.99</h6-->
                                        </div>
                                    </div>
                                    <h6 class="item-name">
                                        <a class="text-body" href="{{url('app/ecommerce/details')}}">{{ $producto->nombre }}</a>
                                        <span class="card-text item-company">By <a href="#" class="company-name">{{ $producto->SDK }}</a></span>
                                    </h6>
                                    <p class="card-text item-description">
                                        {{ $producto->descripcion }}
                                    </p>
                                </div>

                                <div class="item-options text-center">
                                    <div class="item-wrapper">
                                        <div class="item-cost">
                                            <!--h4 class="item-price">$339.99</h4-->
                                        </div>
                                    </div>
                                    <a href="{{url('/producto/'.Str::slug($producto->nombre." ".$producto->modelo,'-'))}}" class="btn btn-light btn-wishlist">
                                        <i class="fa-solid fa-info"></i>
                                        <span>Detalles</span>
                                    </a>
                                    <a href="#" class="btn btn-primary btn-cart">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        <span class="add-to-cart">Agregar al Carrito</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </section>
            @if($productos instanceof \Illuminate\Pagination\LengthAwarePaginator )

                {{$productos->links()}}

            @endif
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<!-- Vendor js files -->
<script src="{{ asset('vendors/js/extensions/wNumb.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/nouislider.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
<!-- Page js files -->
<script src="{{ asset('js/scripts/pages/app-ecom.js') }}"></script>
@endsection
