<!-- Ecommerce Sidebar Starts -->
<div class="sidebar-shop priority-w">
  <div class="row">
    <div class="col-sm-12">
      <h6 class="filter-heading d-none d-lg-block">Categorias & Subcategorias</h6>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <!-- Price Filter starts -->
      <div class="multi-range-price">
        <ul class="list-category">
          @foreach ($categorias as $categoria)
          <li>
              <a data-toggle="collapse" href="#categoria-{{ $categoria->id}}" role="button" aria-expanded="false" aria-controls="categoria-{{ $categoria->id}}">
                  <i class="fas {{ $categoria->icon }}" style="margin-right: 10px;color:#6f45e6;"></i> {{ $categoria->nombre }}
              </a>
              <div class="collapse" id="categoria-{{ $categoria->id}}">
                  <div class="card card-body">
                      <ul class="subcategory-list">
                          @foreach ($categoria->subcategorias as $subcategoria)
                          <li><a href="{{ url('/subcategoria/sub-'.Str::slug($subcategoria->nombre,'-')) }}">{{ $subcategoria->nombre }}</a> </li>
                          @endforeach
                      </ul>
                  </div>
              </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Ecommerce Sidebar Ends -->
