@if ($configData['mainLayoutType'] === 'horizontal' && isset($configData['mainLayoutType']))
  <nav
    class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center {{ $configData['navbarColor'] }}"
    data-nav="brand-center">
    <div class="navbar-header d-xl-block d-none">
      <ul class="nav navbar-nav">
        <li class="nav-item">
          <a class="navbar-brand" href="{{ url('/') }}">
                <span class="brand-logo">
                    <img src="{{ asset('imgs/logos/alpha.png') }}" alt="" style="width: 40px;">
                </span>
                <h2 class="brand-text mb-0">Alpha Promos</h2>
          </a>
        </li>
      </ul>
    </div>
  @else
    <nav
      class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }} {{ $configData['layoutWidth'] === 'boxed' && $configData['verticalMenuNavbarType'] === 'navbar-floating'? 'container-xxl': '' }}">
@endif
<div class="navbar-container d-flex content">
  <div class="bookmark-wrapper d-flex align-items-center">
    <ul class="nav navbar-nav d-xl-none">
      <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
            data-feather="menu"></i></a></li>
    </ul>
    <ul class="nav navbar-nav bookmark-icons">
      <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{ url('/') }}"
          data-bs-toggle="tooltip" data-bs-placement="bottom" title="Email"><img src="{{ asset('imgs/logos/alpha_icon.png') }}" alt="Alpha Promos" style="width:25px;"></a></li>
      <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#"
          data-bs-toggle="tooltip" data-bs-placement="bottom" title="Chat" style="margin-top: 5px;">Alpha Promos</a></li>
    </ul>
  </div>
  <ul class="nav navbar-nav align-items-center ms-auto">
    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon"
          data-feather="{{ $configData['theme'] === 'dark' ? 'sun' : 'moon' }}"></i></a></li>
    <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon"
          data-feather="search"></i></a>
      <div class="search-input">
        <div class="search-input-icon"><i data-feather="search"></i></div>
        <form action="{{ route('home.busqueda') }}" method="get">
          @csrf
          <input class="form-control input search-product" type="text" name="search_global" placeholder="Explore Vuexy..." tabindex="-1" data-search="search">
        </form>
        <div class="search-input-close"><i data-feather="x"></i></div>
        <ul class="search-list search-list-main"></ul>
      </div>
    </li>
    <li class="nav-item dropdown dropdown-cart me-25">
      <a class="nav-link" href="javascript:void(0);" data-bs-toggle="dropdown">
        <i class="ficon" data-feather="shopping-cart"></i>
        <span class="badge rounded-pill bg-primary badge-up cart-item-count contador-cart">6</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
        <li class="dropdown-menu-header">
          <div class="dropdown-header d-flex">
            <h4 class="notification-title mb-0 me-auto">Mi Carrito</h4>
            <div class="badge rounded-pill badge-light-primary"><span class="contador-cart"></span> Productos</div>
          </div>
        </li>
        <li class="scrollable-container media-list items-hooked">
        </li>
        <li class="dropdown-menu-footer" style="margin-top: 20px;">
          <a class="btn btn-primary w-100" href="{{ url('app/ecommerce/checkout') }}">Cotizar</a>
        </li>
      </ul>
    </li>
  </ul>
</div>
</nav>

<!-- END: Header-->
