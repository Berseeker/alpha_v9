@extends('layouts/contentLayoutMaster')

@section('title', 'Orders')

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
      <h4 class="card-title">Lista de Cotizaciones</h4>
    </div>
    <div class="card-datatable table-responsive pt-0" style="overflow-x: inherit;">
      <table class="cotizacion-list-table table">
        <thead class="table-light">
          <tr>
            <th></th>
            <th>UUID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Estatus</th>
            <th>Asesor</th>
            <th>Acciones</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- list and filter end -->
</section>

<div class="modal" tabindex="-1" id="edicion-rapida">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edición rapida cotizacion  #<span id="cotizacion-id"></span></h5>
      </div>
      <form action="{{ route('dashboard.update_quick.cotizacion') }}" method="POST">
        <div class="modal-body">
            @csrf
            <div class="form-group">
              <label for="empleados">Estatus</label>
              <select name="estatus" class="form-control">
                <option value="APPROVED">Aprobada</option>
                <option value="PENDANT">Pendiente</option>
                <option value="CANCEL">Cancelada</option>
                <option value="REVIEWING">En Revisión</option>
              </select>
            </div>
            <input type="hidden" name="cotizacion_id" id="cotizacion_id">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Editar</button>
        </div>
      </form>
    </div>
  </div>
</div>

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
  <script src="{{ asset('js/scripts/pages/app-ordenes.js') }}"></script>

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
    $("#close-modal").click(function () {
        $('#edicion-rapida').modal({ show: false })
    });
  </script>
@endsection
