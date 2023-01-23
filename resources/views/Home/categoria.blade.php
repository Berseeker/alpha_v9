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
                                        $img = Storage::url($img);
                                    }
                                }
                            @endphp 
                            <img src="{{ $img }}" alt="{{ $producto->name }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>


@endsection

@section('page-scripts')

@endsection
