<?php

namespace App\Http\Controllers\API\Buscador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Subcategoria;

class BuscadorController extends Controller
{
    public function search($search)
    {
        $productos = Producto::search($search)->get();
        return $productos->toJson();
    }

    public function getSubcategorias($id)
    {
        $categoria = Categoria::find($id);
        if($categoria != null){
            $subcategorias = Subcategoria::where('categoria_id','=',$categoria->id)->get();
            return $subcategorias->toJson();
        }
    }
}
