<footer class="new_footer_area bg_color">
      <div class="new_footer_top">
          <div class="container">
              <div class="row">
                  <div class="col-lg-3 col-md-6">
                      <div class="f_widget company_widget wow fadeInLeft" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;">
                          <h3 class="f-title f_600 t_color f_size_18">Suscríbete!</h3>
                          <p>No te pierdas ninguno de nuestros catálogos!</p>
                            <!--form action="{{ url('/subscribe') }}" class="f_subscribe_two mailchimp" method="POST" id="subscribe">
                                @csrf
                                <input type="email" name="email" class="form-control memail" placeholder="Email" required>
                                <button class="btn btn_get btn_get_two" type="submit">Suscríbete</button>
                                <p class="mchimp-errmessage" style="display: none;"></p>
                                <p class="mchimp-sucmessage" style="display: none;"></p>
                            </form-->
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="f_widget about-widget pl_70 wow fadeInLeft" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                            <h3 class="f-title f_600 t_color f_size_18">Destacados</h3>
                            <ul class="list-unstyled f_list">
                                <li><a href="{{ url('/categoria/salud-y-cuidado-personal') }}">Salud y Cuidado Personal</a></li>
                                <li><a href="{{ url('/categoria/ecologicos') }}">Ecológicos</a></li>
                                <li><a href="{{ url('/categoria/viaje') }}">Viaje</a></li>
                                <li><a href="{{ url('/categoria/textil') }}">Textil</a></li>
                            </ul>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="f_widget about-widget pl_70 wow fadeInLeft" data-wow-delay="0.6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInLeft;">
                            <h3 class="f-title f_600 t_color f_size_18">Ayuda</h3>
                            <ul class="list-unstyled f_list">
                                <li><a href="{{ url('/contacto') }}">Contacto</a></li>
                                <li><a href="#">Términos y Condiciones</a></li>
                            </ul>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <div class="f_widget social-widget pl_70 wow fadeInLeft" data-wow-delay="0.8s" style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInLeft;">
                          <h3 class="f-title f_600 t_color f_size_18">Redes Sociales</h3>
                          <div class="f_social_icon">
                              <a href="https://wa.me/+525534167685" target="_blank" class="fab fa-whatsapp"></a>
                              <a href="https://www.facebook.com/alphapromos.mx/" target="_blank" class="fab fa-facebook"></a>
                              <!--a href="#" class="fab fa-twitter"></a>
                              <a href="#" class="fab fa-pinterest"></a-->
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="footer_bg">
              <div class="footer_bg_one"></div>
              <div class="footer_bg_two"></div>
          </div>
      </div>
      <div class="footer_bottom">
          <div class="container">
              <div class="row align-items-center">
                  <div class="col-lg-6 col-sm-7">
                      <p class="mb-0 f_400">© AlphaPromos {{ now()->year }} Todos los derechos reservados.</p>
                      <p class="mb-0 f_400">© cakecounter Inc.. {{ now()->year }} Todos los derechos reservados.</p>
                  </div>
                  <div class="col-lg-6 col-sm-5 text-right">
                      <p>Hecho con <i class="fas fa-heart" style="color:red;"></i> por <a href="#">JuanPi</a></p>
                  </div>
              </div>
          </div>
      </div>
</footer>