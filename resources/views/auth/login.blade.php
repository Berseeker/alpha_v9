@php
$configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'Login Alpha')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/pages/authentication.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-cover">
  <div class="auth-inner row m-0">
    <!-- Brand logo-->
    <a class="brand-logo" href="{{ url('/') }}" style="color:#2098d1;">
        <img src="{{ asset('imgs/logos/alpha.png') }}" alt="Alpha Promos" style="width:50px;">
        <h2 class="brand-text text-primary ms-1" style="padding-top: 15px;">Alpha Promos</h2>
    </a>
    <!-- /Brand logo-->

    <!-- Left Text-->
    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
      <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
        @if($configData['theme'] === 'dark')
          <img class="img-fluid" src="{{asset('images/pages/login-v2-dark.svg')}}" alt="Login V2" />
          @else
          <img class="img-fluid" src="{{asset('images/pages/login-v2.svg')}}" alt="Login V2" />
          @endif
      </div>
    </div>
    <!-- /Left Text-->

    <!-- Login-->
    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
      <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
        <h2 class="card-title fw-bold mb-1">Bienvenidos a Alpha Promos! 👋</h2>
        <p class="card-text mb-2">Por favor inicia sesion y empieza la aventura</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="padding:3px;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="auth-login-form mt-2" action="{{ url('/login') }}" method="POST">
            @csrf
          <div class="mb-1">
            <label class="form-label" for="login-email">Correo electrónico</label>
            <input class="form-control" id="login-email" type="text" name="email" placeholder="john@example.com" aria-describedby="login-email" autofocus="" tabindex="1" />
          </div>
          <div class="mb-1">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="login-password">Contraseña</label>
              <a href="{{url("auth/forgot-password-cover")}}">
                <small>Forgot Password?</small>
              </a>
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input class="form-control form-control-merge" id="login-password" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2" />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
          </div>
          <div class="mb-1">
            <div class="form-check">
              <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3" />
              <label class="form-check-label" for="remember-me"> Recuerdame</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100" tabindex="4">Iniciar Sesion</button>
        </form>
        <p class="text-center mt-2">
          <span>Nuevo en la plataforma?</span>
          <span>&nbsp;Contacta a un administrador</span>
        </p>
      </div>
    </div>
    <!-- /Login-->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/auth-login.js')}}"></script>
@endsection
