@extends('layouts/fullLayoutMaster')

@section('title', 'Factura - '.$cotizacion->id)

@section('page-style')
<link rel="stylesheet" href="{{asset('css/base/pages/app-invoice-print.css')}}">
@endsection

@section('content')
<div class="invoice-print p-3">
  <div class="invoice-header d-flex justify-content-between flex-md-row flex-column pb-2">
    <div>
      <div class="d-flex mb-1">
        <img src="{{ asset('imgs/logos/alpha_icon.png') }}" alt="AlphaPromos" style="width: 30px;margin-right:10px;">
        <h3 class="text-primary font-weight-bold ml-1" style="margin-top: 8px;">AlphaPromos</h3>
      </div>
      <p class="mb-25">Office 149, 450 South Brand Brooklyn</p>
      <p class="mb-25">San Diego County, CA 91905, USA</p>
      <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p>
    </div>
    <div class="mt-md-0 mt-2">
      <h4 class="font-weight-bold text-right mb-1">INVOICE #{{ $cotizacion->id }}</h4>
      <div class="invoice-date-wrapper mb-50">
        <span class="invoice-date-title">Fecha de Emision:</span>
        <span class="font-weight-bold"> {{ now() }}</span>
      </div>
      <!--div class="invoice-date-wrapper">
        <span class="invoice-date-title">Due Date:</span>
        <span class="font-weight-bold">29/08/2020</span>
      </div-->
    </div>
  </div>

  <hr class="my-2" />

  <div class="row pb-2">
    <div class="col-sm-6">
        <h6 class="mb-1">Factura para:</h6>
        <p class="mb-25">{{ $cotizacion->ciudad.', '.$cotizacion->estado }}</p>
        <p class="mb-25">{{ $cotizacion->colonia.', '.$cotizacion->calle.', '.$cotizacion->cp }}</p>
        <p class="mb-25">{{ $cotizacion->celular }}</p>
        <p class="mb-0">{{ $cotizacion->email }}</p>
    </div>
    <div class="col-sm-6 mt-sm-0 mt-2">
      <h6 class="mb-1">Detalles del pago:</h6>
      <table>
        <tbody>
          <tr>
            <td class="pr-1">A pagar:</td>
            <td><strong>$ {{ number_format($cotizacion->precio_total) }}</strong></td>
          </tr>
          <tr>
            <td class="pr-1">Banco:</td>
            <td>Santander</td>
          </tr>
          <tr>
            <td class="pr-1">Pais:</td>
            <td>Mexico</td>
          </tr>
          <tr>
            <td class="pr-1">IBAN:</td>
            <td>ETD95476213874685</td>
          </tr>
          <tr>
            <td class="pr-1">SWIFT code:</td>
            <td>BR91905</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="table-responsive mt-2">
    <table class="table m-0">
      <thead>
        <tr>
          <th class="py-1 pl-4">Descripcion de la Cotizacion</th>
          <th class="py-1">Precio/Pza</th>
          <th class="py-1">Piezas</th>
          <th class="py-1">Total</th>
        </tr>
      </thead>
      <tbody>
            @foreach ($productos as $producto)
            <tr>
                <td class="py-1 pl-4">
                    <p class="font-weight-semibold mb-25">{{ $producto->nombre }}</p>
                    <!--p class="text-muted text-nowrap">
                    Developed a full stack native app using React Native, Bootstrap & Python
                    </p-->
                </td>
                <td class="py-1">
                    <strong>${{ number_format($producto->precio_pza) }}</strong>
                </td>
                <td class="py-1">
                    <strong>{{ $producto->num_pzas }}</strong>
                </td>
                <td class="py-1">
                    <strong>{{ $producto->precio_producto }}</strong>
                </td>
            </tr>
            @endforeach
      </tbody>
    </table>
  </div>

  <div class="row invoice-sales-total-wrapper mt-3">
    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
      <p class="card-text mb-0">
        <span class="font-weight-bold">Vendedor:</span> <span class="ml-75">{{ $cotizacion->user->name }}</span>
      </p>
    </div>
    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
      <div class="invoice-total-wrapper" style="margin-right:80px;">
        <div class="invoice-total-item">
          <p class="invoice-total-title">Subtotal:</p>
          <p class="invoice-total-amount">$13</p>
        </div>
        <!--div class="invoice-total-item">
          <p class="invoice-total-title">Discount:</p>
          <p class="invoice-total-amount">$28</p>
        </div-->
        <div class="invoice-total-item">
          <p class="invoice-total-title">IVA:</p>
          <p class="invoice-total-amount">16%</p>
        </div>
        <hr class="my-50" />
        <div class="invoice-total-item">
          <p class="invoice-total-title">Total:</p>
          <p class="invoice-total-amount">${{ number_format($cotizacion->precio_total) }}</p>
        </div>
      </div>
    </div>
  </div>

  <hr class="my-2" />

  <div class="row">
    <div class="col-12">
      <span class="font-weight-bold">Nota:</span>
      <span
        >Fue un placer trabajar con usted y su equipo. Esperamos que nos tengas en cuenta para futuros proyectos ¡Gracias!</span
      >
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/app-invoice-print.js')}}"></script>
@endsection
