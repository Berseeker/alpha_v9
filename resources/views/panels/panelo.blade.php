@php
$configData = Helper::applClasses();
@endphp
<div
  class="main-menu menu-fixed {{ $configData['theme'] === 'dark' || $configData['theme'] === 'semi-dark' ? 'menu-dark' : 'menu-light' }} menu-accordion menu-shadow"
  data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item me-auto">
        <a class="navbar-brand" href="{{ url('/') }}">
            <span class="brand-logo">
              <img src="{{ asset('imgs/logos/alpha.png') }}" alt="" style="width: 30px;">
            </span>
            <h2 class="brand-text">Alpha Promos</h2>
        </a>
      </li>
      <li class="nav-item nav-toggle">
        <a class="nav-link modern-nav-toggle pe-0" data-toggle="collapse">
          <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
          <i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc"
            data-ticon="disc"></i>
        </a>
      </li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      {{-- Foreach menu item starts --}}
        @foreach ($categorias as $categoria)
          <li class="nav-item has-sub">
              <a class="d-flex align-items-center" href="#categoria-{{ $categoria->id}}" target="_self" aria-controls="categoria-{{ $categoria->id}}">
                  <i class="fas {{ $categoria->icon }} fa-sm" style="margin-right: 10px;color:red;font-size:1rem;top:8px;"></i>
                  <span class="menu-title text-truncate">{{ $categoria->nombre }}</span>
              </a>
  
            <ul class="menu-content subcategory-list">
                @foreach ($categoria->subcategorias as $subcategoria)
                <li>
                    <a href="{{ url(Str::slug($subcategoria->categoria->nombre, '-') . '/subcategoria/' . Str::slug($subcategoria->nombre,'-')) }}" class="d-flex align-items-center" target="_self" style="font-size:11px;">
                        <i class="fa-solid fa-compact-disc" style="margin-right: 10px;font-size:1rem;top:8px;"></i>
                        <span class="menu-title text-truncate">{{ $subcategoria->nombre }}</span>
                    </a> 
                </li>
                @endforeach
            </ul> 
          </li>
        @endforeach
      {{-- Foreach menu item ends --}}
    </ul>
  </div>
</div>
<!-- END: Main Menu-->
