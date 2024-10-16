@extends('layouts/contentLayoutMaster')

@section('title', 'Lista Productos')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
@endsection

@section('content')
<!-- users list start -->
<section class="app-user-list">
  <div class="row">
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">0</h3>
            <span>Productos 4Promotional</span>
          </div>
          <div class="avatar bg-light-primary p-50">
            <span class="avatar-content">
              <i data-feather="user" class="font-medium-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">0</h3>
            <span>Productos Innovation</span>
          </div>
          <div class="avatar bg-light-danger p-50">
            <span class="avatar-content">
              <i data-feather="user-plus" class="font-medium-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">0</h3>
            <span>Productos PromoOpcion</span>
          </div>
          <div class="avatar bg-light-success p-50">
            <span class="avatar-content">
              <i data-feather="user-check" class="font-medium-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h3 class="fw-bolder mb-75">0</h3>
            <span>Productos DobleVela</span>
          </div>
          <div class="avatar bg-light-warning p-50">
            <span class="avatar-content">
              <i data-feather="user-x" class="font-medium-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
    @if (session('success'))
        <div class="alert alert-success" style="padding: 8px;">
            {{ session('success') }}
        </div>
    @endif
     @if (session('error'))
        <div class="alert alert-danger" style="padding: 8px;">
            {{ session('error') }}
        </div>
    @endif
  <!-- list and filter start -->
  <div class="card">
    <div class="card-body border-bottom">
      <h4 class="card-title">Lista de Productos & Filtros</h4>
      <!--div class="row">
        <div class="col-md-4 user_role"></div>
        <div class="col-md-4 user_plan"></div>
        <div class="col-md-4 user_status"></div>
      </div-->
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="cotizacion-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Nº Productos</th>
            <th>Estatus</th>
            <th>Acciones</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- list and filter end -->
</section>
<!-- users list ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/jszip.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/cleave/cleave.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>

  <script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset('js/scripts/pages/app-cotizacion-listo.js') }}"></script>

  <script src="{{ asset('js/scripts/extensions/ext-component-sweet-alerts.js') }}"></script>
  <script>
    function deleteConfirmation(id) {
            swal.fire({
                title: "Borrar?",
                icon: 'warning',
                text: "Por favor confirma la accion!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Si, borrarlo!",
                cancelButtonText: "No, cancelar!",
                confirmButtonColor: '#007600',
                cancelButtonColor: '#d33',
                reverseButtons: !0
            }).then(function (e) 
            {
                if (e.value === true) 
                {
                    let _url = "{{url('/')}}";
                    $.ajax({
                        type: 'POST',
                        url: _url+'/api/delete-cotizacion/'+id,
                        success: function (resp) {
                            console.log(resp);
                            if (resp.status == 'success') {
                                swal.fire("Done!", resp.msg, "success").then(function(e){
                                  if(e.value == true)
                                  {
                                    location.reload();
                                  }
                                });
                                //location.reload();
                            } else {
                                swal.fire("Error!", 'Something went wrong.', "error");
                            }
                        },
                        error: function (resp) {
                            console.log(resp)
                            swal.fire("Error!", 'Something went wrong.', "error");
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
    }
  </script>
@endsection