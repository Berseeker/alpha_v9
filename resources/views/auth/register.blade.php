@php
$configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'Register Page')

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
        <img class="img-fluid" src="{{asset('images/pages/register-v2-dark.svg')}}" alt="Register V2" />
        @else
        <img class="img-fluid" src="{{asset('images/pages/register-v2.svg')}}" alt="Register V2" />
        @endif
      </div>
    </div>
    <!-- /Left Text-->

    <!-- Register-->
    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
      <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
        <h2 class="card-title fw-bold mb-1">La aventura comienza ahora 🚀</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="padding:3px;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="auth-register-form mt-2" action="{{ url('/register') }}" method="POST">
            @csrf
          <div class="mb-1">
            <label class="form-label" for="register-username">Nombre</label>
            <input class="form-control" id="register-username" type="text" name="name" placeholder="johndoe" aria-describedby="register-username" autofocus="" tabindex="1" />
          </div>
          <div class="mb-1">
            <label class="form-label" for="register-email">Correo electronico</label>
            <input class="form-control" id="register-email" type="text" name="email" placeholder="john@example.com" aria-describedby="register-email" tabindex="2" />
          </div>
          <div class="mb-1">
            <label class="form-label" for="register-password">Contraseña</label>
            <div class="input-group input-group-merge form-password-toggle">
              <input class="form-control form-control-merge" id="register-password" type="password" name="password" placeholder="············" aria-describedby="register-password" tabindex="3" />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
          </div>
          <div class="mb-1">
            <label class="form-label" for="register-password-confirmation">Confirmar Contraseña</label>
            <div class="input-group input-group-merge form-password-toggle">
              <input class="form-control form-control-merge" id="register-password-confirmation" type="password" name="password_confirmation" placeholder="············" aria-describedby="register-password" tabindex="3" />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
          </div>
          <!--div class="mb-1">
            <div class="form-check">
              <input class="form-check-input" id="register-privacy-policy" type="checkbox" tabindex="4" />
              <label class="form-check-label" for="register-privacy-policy">I agree to<a href="#">&nbsp;privacy policy & terms</a></label>
            </div>
          </div-->
          <button type="submit" class="btn btn-primary w-100" tabindex="5">Crear cuenta</button>
        </form>
        <p class="text-center mt-2">
          <span>Ya tienes una cuenta?</span>
          <a href="{{url('/login')}}"><span>&nbsp;Iniciar Sesion</span></a>
        </p>
      </div>
    </div>
    <!-- /Register-->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('js/scripts/pages/auth-register.js') }}"></script>
@endsection
