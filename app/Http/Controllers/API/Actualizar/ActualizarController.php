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
            $subcategorias = Subcategoria::where('categoria_id',$categoria->id)->where('deleted_at','!=',null)->get();

            if($subcategorias->isEmpty())
            {
                $categoria->delete();
            }
        }

        return response()->json([
            'status' => 'La tarea se realizo con exito'
        ]);
    }

    public function restore()
    {
        $subcategorias = Subcategoria::onlyTrashed()->get();

        foreach ($subcategorias as $subcategoria) {
            $productos = Producto::where('subcategoria_id',$subcategoria[0]->id)->get();
            if(!$productos->isEmpty())
            {
                $subcategoria[0]->restore();
            }
        }

        $categorias = Categoria::onlyTrashed()->get();

        foreach ($categorias as $categoria) {
            $subcategorias = Subcategoria::where('categoria_id',$categoria[0]->id)->where('deleted_at','!=',null)->get();
            if(!$subcategorias->isEmpty())
            {
                $categoria[0]->restore();
            }
        }
    }
}
