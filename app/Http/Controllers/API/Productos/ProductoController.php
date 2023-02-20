<?php

namespace App\Http\Controllers\API\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Producto;
use App\Models\Product;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = DB::table('products')
            ->join('categorias', 'products.categoria_id', '=', 'categorias.id')
            ->join('subcategorias', 'products.subcategoria_id', '=', 'subcategorias.id')
            ->select('products.id','products.name','products.code', 'products.categoria_id', 'products.images', 'categorias.nombre as categoria', 'subcategorias.nombre as subcategoria', 'products.proveedor as proveedor')
            ->get()->toJson();
        
        return $productos;
    }

    public function producto($sdk)
    {
        $producto = Product::where('code',$sdk)->first();

        $img = asset('imgs/no_disp.png');
        if($producto->images != null)
        {
            $img = json_decode($producto->images)[0];
            if(!Str::contains($img,['https','http']))
            {
                $img = Storage::disk('doblevela_img')->url($img);
            }
        }

        return response()->json([
            'nombre' => $producto->name,
            'sdk' => $producto->code,
            'img' => $img
        ]);

        //return $producto;
    }

}
