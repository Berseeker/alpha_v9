@extends('layouts.web')

@section('title', 'Categorias')

@section('page-styles')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('css/v3/home/categoria_home.css') }}">
@endsection


@section('content')
<div class="container">
    <section id="categoria-header">
        <h3> <img src=" {{ asset('imgs/v3/logos/alpha.ico') }} " alt="AlphaPromos" id="alphaCateg"> Categorias </h3>
    </section>
    <section id="categorias-destacadas">
        <h3>Categorias destacadas</h3>
        <div class="parent">
            <a href="{{ url('/categoria/boligrafos') }}" class="d-flex align-items-end child bg-one">
                <p>Bolígrafos</p>
            </a>
        </div>
        <div class="parent">
            <a href="{{ url('/categoria/ecologicos') }}" class="d-flex align-items-end child bg-two">
                <p>Ecológicos</p>
            </a>
        </div>
        <div class="parent">
            <a href="{{ url('/categoria/herramientas') }}" class="d-flex align-items-end child bg-three">
                <p>Herramientas</p>
            </a>
        </div>
        <div class="parent">
            <a href="{{ url('/categoria/hogar') }}" class="d-flex align-items-end child bg-four">
                <p>Hogar</p>
            </a>
        </div>
        <div class="parent">
            <a href="{{ url('/categoria/oficina') }}" class="d-flex align-items-end child bg-five">
                <p>Oficína</p>
            </a>
        </div>
        <div class="parent">
            <a href="{{ url('/categoria/paraguas') }}" class="d-flex align-items-end child bg-six">
                <p>Paraguas</p>
            </a>
        </div>
        <div class="parent">
            <a href="{{ url('/categoria/salud-y-cuidado-personal') }}" class="d-flex align-items-end child bg-seven">
                <p>Salud</p>
            </a>
        </div>
        <div class="parent">
            <a href="{{ url('/categoria/tecnologia') }}" class="d-flex align-items-end child bg-eight">
                <p>Tecnología</p>
            </a>
        </div>
        <div class="parent">
            <a href="{{ url('/categoria/textil') }}" class="d-flex align-items-end child bg-nine">
                <p>Textil</p>
            </a>
        </div>
        <div class="parent">
            <a href="{{ url('/categoria/viaje') }}" class="d-flex align-items-end child bg-ten">
                <p>Viaje</p>
            </a>
        </div>
    </section>
</div>
@endsection

@section('page-scripts')
@endsection
