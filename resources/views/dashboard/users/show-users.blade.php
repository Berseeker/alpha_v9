@extends('layouts/contentLayoutMaster')

@section('title', 'Editando Usuarios')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset('css/old/pickadate.css') }}">
        <script src="{{ asset('js/old/jquery.min.js')}}"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection

@section('content')

<section id="basic-vertical-layouts">
  <div class="row match-height">
    <div class="offset-md-3 col-md-6 col-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fas fa-pencil-alt" style="font-size: 30px;color: orange;margin-right: 10px;"></i>Editando Usuarios</h4>
            <a href="{{ route('users.create') }}" class="btn btn-info">Crear Usuarios</a>
        </div>
        <div class="card-content">
            <div class="card-body">
               @if($errors->any())
                  <div class="alert alert-danger " >
                      <ul style="list-style: none;">
                          @foreach($errors->all() as $error)
                              <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$error}}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              @if (session('success'))
                  <div class="bg-success" style="padding:10px;margin-bottom:30px;text-align:center;border-radius:5px;color:white;">
                      <p style="margin-bottom: 0px;"><i class="fas fa-thumbs-up" style="margin-right: 10px;"></i> {{ session('success') }}</p>
                  </div>
              @endif 
              @if (session('warning'))
                  <div class="bg-warning" style="padding:10px;margin-bottom:30px;border-radius: 5px;color:white;text-align:center;">
                      <p style="margin-bottom: 0px;"><i class="fas fa-exclamation" style="margin-right: 10px;"></i> {{ session('warning') }}</p>
                  </div>
              @endif
              
                @foreach ($users as $user)
                    @if ($user->email != Auth::user()->email)
                        <form class="form form-vertical"  method="POST" action="{{ url('/dashboard/update-user/'.$user->id) }}" style="margin-bottom: 20px;">
                            @csrf    
                            <div class="form-group" style="margin-top:10px;">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input type="text" class="form-control" name ="name" value="{{$user->name}}">

                            </div>
                            <div class="form-group" style="margin-top:10px;">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" name ="email" value="{{$user->email}}">
                            </div>

                            <div class="form-group" style="margin-top:10px;">
                                <label for="exampleInputEmail1">Roles</label>
                                <select name="roles" class="form-control">
                                    @foreach ($roles as $role)
                                        @if ($user->hasRole(['Admin', 'Supervisor', 'Empleado', 'Usuario'])  && $role->name == $user->getRoleNames()[0])
                                            <option value="{{ $role->id }}" selected> {{ $role->name}}</option>
                                        @else
                                            <option value="{{ $role->id }}">{{$role->name}} </option>
                                        @endif          
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-top:25px;">
                                <div class="row">
                                    <div class="col-sm-6 d-flex justify-content-start">
                                        <div class="form-group"><button type="submit" class="btn btn-primary">Editar</button></div>
                                        <a href="{{ url("dashboard/delete-users/".$user->id) }}" class="btn btn-danger" style="margin-left:20px;">Eliminar</a> 
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                @endforeach
                   

              

            </div><!-- End card-body-->
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset('vendors/js/pickers/pickadate/picker.js') }}"></script>
        <script src="{{ asset('vendors/js/pickers/pickadate/picker.date.js') }}"></script>
        <script src="{{ asset('vendors/js/pickers/pickadate/picker.time.js') }}"></script>
        <script src="{{ asset('vendors/js/pickers/pickadate/legacy.js') }}"></script>
        <script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('js/scripts/forms/pickers/form-pickers.js') }}"></script>
@endsection
