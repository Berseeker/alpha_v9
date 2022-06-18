<?php

namespace App\Http\Controllers\API\Actualizar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subcategoria;
use App\Models\Categoria;
use App\Models\Producto;

class ActualizarController extends Controller
{
    public function index()
    {
        $subcategorias = Subcategoria::all();

        $categorias = Categoria::all();

        foreach ($subcategorias as $subcategoria) {
            $productos = Producto::where('subcategoria_id',$subcategoria->id)->get();

            if($productos->isEmpty())
            {
                $subcategoria->delete();
            }
        }

        foreach ($categorias as $categoria) {
            $subcategorias = Subcategoria::where('categoria_id',$categoria->id)->get();

            if($subcategorias->isEmpty())
            {
                $categoria->delete();
            }
        }

        return response()->json([
            'status' => 'La tarea se realizo con exito'
        ]);
    }
}
