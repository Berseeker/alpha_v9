<nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index') }}"><img src="{{ asset('imgs/v3/logos/logo_alpha.png') }}" id="logo-img" alt="AlphaPromos"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex align-items-center" id="navbar-menu">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('index') }}">INICIO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="categoria-nav-mob" href="#">CATEGORIAS <i class="fa-solid fa-caret-down"></i></a>
                    <a class="nav-link" id="categoria-nav" href="#">CATEGORIAS <i class="fa-solid fa-caret-down"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home.servicios') }}">SERVICIOS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home.displays') }}">DISPLAYS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home.contacto') }}">CONTACTO</a>
                </li>
                <li class="nav-item custom-li">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscador" aria-label="Buscador" aria-describedby="basic-addon2" id="search-global">
                        <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                    <ul id="searched-items"></ul>
                </li>
            </ul>
        </div>
        <div>
            <ul class="navbar-nav" id="redes-sociales">
                <li><a href="https://www.facebook.com/alphapromos.mx" target="_blank"><i class="fa-brands fa-facebook fb-color fs-30"></i></a></li>
                <li><a href="https://www.instagram.com/alpha.promos.mx" target="_blank"><i class="fa-brands fa-instagram insta-color fs-30"></i></a></li>
                <li><a href="https://api.whatsapp.com/send?phone=529981098156" target="_blank"><i class="fa-brands fa-whatsapp whats-color fs-30"></i></a></li>
                <li class="nav-item mr-40">
                    <div class="dropdown">
                        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-cart-shopping alpha-color" aria-hidden="true"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-number">
                                
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </button>
                        <div class="dropdown-menu" id="menu-carrito">
                            <div class="carrito">
                                <p>Mi Cesta</p>
                                <ul class="items-hooked">
                                    <li>Sin productos!</li>
                                </ul>
                                <div style="padding: 8px;">
                                    <a href="{{ route('home.cotizacion') }}" class="sent-cart"> <i class="fa-solid fa-check" style="margin-right: 10px;"></i>Cotizar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="menu-alpha">
    <div id="holder">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="row">
                    @php
                        $contador = 1;
                    @endphp
                    @foreach ($categorias as $categoria)
                        @if ($contador == 9 || $contador == 17)
                            </div>
                        @endif
                        @if ($contador == 1 || $contador == 9 || $contador == 17)   
                            <div class="col-xs-12 col-md-4">
                        @endif

                        <div class="btn-group dropend catalogo">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid {{ $categoria->icon }} icon-menu alpha-color"></i> {{ $categoria->nombre }}
                            </button>
                            <ul class="dropdown-menu" style="padding: 8px;">
                                @foreach ($categoria->customSubcategory as $subcategory)
                                    <a href="{{ url('/subcategoria/' . Str::slug($subcategory->nombre, '-')) }}" class="link-catalogo" data="/imgs/v3/menu_navbar/{{ $subcategory->imgs }}" > {{ $subcategory->nombre }} </a>
                                @endforeach
                                <a href="{{ url('/categoria/' . Str::slug($categoria->nombre, '-')) }}" class='link-catalogo' data="textil"> Ver más</a>
                            </ul>
                        </div>
                        @if ($contador == 20)
                            </div>
                        @endif
                        @php
                            $contador++;
                        @endphp
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-md-4" id="img-menu">
            </div>
        </div>
    </div>
</div>