
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white shadow-sm" id="home-navbar">
    <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('img/logos/logo_alpha.png') }}" id="logo_alpha" alt="AlphaPromos"></a>
    <!--a href="#" class="navbar-brand font-weight-bold d-block d-lg-none">MegaMenu</a-->
    <button type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarContent" class="collapse navbar-collapse">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a href="/" class="nav-link font-weight-bold text-uppercase hvr-underline-from-left">Inicio</a></li>
            <li class="nav-item dropdown megamenu">
                <a id="megamneu" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle font-weight-bold text-uppercase hvr-underline-from-left">Categorías</a>
                <div aria-labelledby="megamneu" class="dropdown-menu border-0 p-0 m-0">
                    <div class="">
                        <div class="row bg-white rounded-0 m-0 shadow-sm">
                            <div class="col-lg-12 col-xl-12">
                                <div class="p-4">
                                    <div class="row" id="categorias-box">
                                        
                                        @foreach ($categorias as $categoria)
                                            <div class="col-12 col-sm-3 col-md-2 col-lg-2 col-xl-2" style="margin-bottom:10px;">
                                                <h6 class="text-uppercase"> 
                                                    <i class="fa {{ $categoria->icon }}"></i>
                                                    <a href="{{ url('/categoria/'.Str::slug($categoria->nombre, '-')) }}" class="custom-a category-title"> {{ $categoria->nombre }} </a>
                                                </h6>
                                                <ul class="list-unstyled">
                                                    @foreach ($categoria->subcategorias as $subcategoria)
                                                        <li class="nav-item"><a href="{{ url('/subcategoria/'.Str::slug($subcategoria->nombre, '-')) }}" class="nav-link custom-a pb-0 hvr-underline-from-center">{{ $subcategoria->nombre }}</a></li>
                                                        @php
                                                                
                                                            if($cont == 2){
                                                                $cont = 1;
                                                                echo '<li class="nav-item"><a href="/categoria/'.$categoria->id.'" class="nav-link custom-a pb-0 hvr-underline-from-center">Ver más...</a></li>';
                                                                break;
                                                            }
                                                            elseif($cont == count($categoria->subcategorias)){
                                                                $cont = 1;
                                                                break;
                                                            }
                                                            $cont++; 
                                                        
                                                        @endphp
                                                    @endforeach
                                                    
                                                
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item"><a href="{{ url('/contacto') }}" class="nav-link font-weight-bold text-uppercase hvr-underline-from-left">Contacto</a></li>
            <li class="nav-item"><a href="{{ url('/servicios') }}" class="nav-link font-weight-bold text-uppercase hvr-underline-from-left">Servicios</a></li>
            <li class="nav-item"> <a href="{{ url('/displays') }}" class="nav-link font-weight-bold text-uppercase hvr-underline-from-left">Alpha Displays</a> </li>
        </ul>
        <ul class="navbar-nav" id="auth-nav">
            <li>
                <a href="" class="nav-link"><i class="fas fa-shopping-cart"></i><span class="badge badge-danger" id="shop-cart">9</span></a>
            </li>
            <!-- Authentication Links -->
            @guest
                <li>
                    <a href="{{ route('login') }}" class="nav-link font-weight-bold text-uppercase"><i class="fas fa-user"></i> Iniciar Sesión</a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="nav-link font-weight-bold text-uppercase"><i class="fas fa-pencil-alt"></i>Registro</a>
                </li>
            @else
                <li>
                    @if (Auth::user()->id_facebook)
                        <img src="{{ Auth::user()->avatar_facebook }}" alt="Perfil Facebook" class="perfil-img">
                    @elseif(Auth::user()->id_google)
                        <img src="{{ Auth::user()->avatar_google }}" alt="Perfil Google" class="perfil-img">
                    @else
                        <img src="{{ asset('img/items/avatar.png') }}" alt="Perfil" class="perfil-img">
                    @endif
                </li>
                <li class="nav-item dropdown d-flex align-items-center">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->nombre }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('account') }}">
                            Cuenta
                        </a>
                        <form action="{{ route('cerrar.sesion') }}" method="POST">
                            @csrf
                            <button class="dropdown-item" type="submit">
                                <i class="feather icon-power"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
<div class="row" id="float-search">
    <form class="form-inline my-2 my-lg-0" id="general-format" method="GET" action="{{ url('/busqueda') }}">
        @csrf
        <div class="searchbar">
            <input class="search_input" id="general_search" name="general_search" type="text" name="" placeholder="Buscar...">
            <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
        </div>
        <!--input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button-->
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#general_search').keypress(function (e) {
                if (e.which == 13) {
                    $('#general-format').submit();
                    //return false;    //<---- Add this line
                }
            });
        });   
    </script>
</div>