<?php

namespace App\Http\Controllers\API\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = DB::table('productos')
            ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->join('subcategorias', 'productos.subcategoria_id', '=', 'subcategorias.id')
            ->select('productos.id','productos.nombre','productos.modelo', 'productos.categoria_id','productos.SDK','productos.proveedor', 'productos.images', 'categorias.nombre as categoria', 'subcategorias.nombre as subcategoria')
            ->get()->toJson();
        
        return $productos;
    }

    public function producto($sdk)
    {
        $producto = Producto::where('SDK',$sdk)->first();

        $img = asset('imgs/no_disp.png');
        if($producto->images != null)
        {
            $img = json_decode($producto->images)[0];
            if(!Str::contains($img,['https','http']))
            {
                $img = Storage::url($img);
            }
        }

        return response()->json([
            'nombre' => $producto->nombre,
            'sdk' => $producto->SDK,
            'img' => $img
        ]);

        //return $producto;
    }

}
