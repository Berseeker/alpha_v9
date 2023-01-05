<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="{{ asset('imgs/logos/logo_alpha.png') }}" id="logo-img" alt="AlphaPromos"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex align-items-center" id="navbar-menu">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">INICIO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="categoria-nav" href="#">CATEGORIAS <i class="fa-solid fa-caret-down"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">SERVICIOS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">DISPLAYS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">LINEA ALPHA</a>
                </li>
                <li class="nav-item custom-li">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscador" aria-label="Buscador" aria-describedby="basic-addon2" id="search-global">
                        <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                </li>
            </ul>
        </div>
        <div>
            <ul class="navbar-nav">
                <li class="nav-item mr-20">
                    <i class="fa-solid fa-cart-shopping"></i>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="menu-alpha">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            @php
                $cont = 1;
            @endphp
            @foreach ($categorias as $categoria)
                @if ($cont == 9 || $cont == 17)
                    </div>
                @elseif ($cont == 1 || $cont == 9 || $cont == 17)   
                    <div class="col-xs-12 col-md-4">
                @endif
                <a href="#"> {{ $categoria->nombre }} </a>
                @if ($cont == 20)
                    </div>
                @endif
                @php
                    $cont++;
                @endphp
            @endforeach
        </div>
        <div class="col-xs-12 col-md-4"></div>
    </div>
</div>