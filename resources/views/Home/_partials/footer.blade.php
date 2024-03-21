<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <h4>Newsletter</h4>
                <form action="{{ route('home.newsletter') }}" method="POST" id="newsletter">
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" id="news-email" name="news_email" class="form-control" placeholder="Correo electrónico">
                        <p id="email-news-error" class="warning-not">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span id="errorMessageEmail"></span>
                        </p>
                        <p id="email-news-success" class="success-not">
                            <i class="fa-solid fa-circle-check"></i>
                            <span id="successMessageEmail"></span>
                        </p>
                    </div>
                    <button type="submit" class="btn btn-alpha">Suscríbete</button>
                </form>
                <p style="margin-top: 40px;font-size:14px;">No te pierdas ninguno de nuestros catálogos!</p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <h4>Destacados</h4>
                <ul id="destacados">
                    <li><a href="{{ url('/categoria/ecologicos') }}">Ecológicos</a></li>
                    <li><a href="{{ url('/categoria/textil') }}">Textil</a></li>
                    <li><a href="{{ url('/categoria/tecnologia') }}">Tecnología</a></li>
                    <li><a href="{{ url('/categoria/sublimacion') }}">Sublimación</a></li>
                    <li><a href="{{ url('/categoria/oficina') }}">Oficina</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <h4>Ayuda</h4>
                <ul id="ayuda">
                    <li><a href="">Acerca de nosotros</a></li>
                    <li><a href="">Contácto</a></li>
                    <li><a href="">Términos y Condiciones</a></li>
                    <li><a href="">Aviso de Privacidad</a></li>
                </ul>
                <h4>Redes Sociales</h4>
                <ul id="redes-sociales">
                    <li><a href="https://www.facebook.com/alphapromos.mx" target="_blank"><i class="fa-brands fa-facebook fb-color"></i></a></li>
                    <li><a href="https://www.instagram.com/alpha.promos.mx" target="_blank"><i class="fa-brands fa-instagram insta-color"></i></a></li>
                    <li><a href="" target="_blank"><i class="fa-brands fa-whatsapp whats-color"></i></a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <h4>Contáctanos</h4>
                <ul id="contactanos">
                    <li>
                        <p class="mb-0"><i class="fa-solid mr-10 fa-location-dot red"></i>Cancún Q.Roo, México</p>
                        <p class="mb-0"><i class="fa-solid mr-10 fa-phone green"></i>(998) 880-5111 / 880-5564 / 140-8894</p>
                        <p class="mb-30"><i class="fa-solid mr-10 fa-envelope-open-text alpha-color"></i>ventas@alphapromos.mx</p>
                    </li>
                    <li>
                        <p class="mb-0"><i class="fa-solid mr-10 fa-location-dot red"></i>CDMX, México</p>
                        <p class="mb-0"><i class="fa-solid mr-10 fa-phone green"></i>(55) 1106-6569</p>
                        <p class="mb-30"><i class="fa-solid mr-10 fa-envelope-open-text alpha-color"></i>ventas@alphapromos.mx</p>
                    </li>
                    <!--li>
                        <p class="mb-0"><i class="fa-solid mr-10 fa-location-dot red"></i>Madrid, España</p>
                        <p class="mb-0"><i class="fa-solid mr-10 fa-phone green"></i>(34) 662-9658-70</p>
                        <p class="mb-30"><i class="fa-solid mr-10 fa-envelope-open-text alpha-color"></i>ventasmadrid@alphapromos.mx</p>
                    </li-->
                </ul>
            </div>
        </div>
    </div>
</footer>