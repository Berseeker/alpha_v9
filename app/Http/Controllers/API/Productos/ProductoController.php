<?php

namespace App\Http\Controllers\API\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        //$productos = DB::table('productos')->with('categoria')->get()->toJson();
        $productos = Producto::with('categoria')->where('deleted_at',null)->get()->toJson();
        
        return $productos;
    }

    public function producto($sdk)
    {
        $producto = Producto::where('SDK',$sdk)->first()->toJson();

        $img = asset('imgs/no_disp.png');
        if($producto->images != null)
        {
            $img = json_decode($product->images)[0];
            if(!Str::contains($img,['https','http']))
            {
                $img = Storage::url($img);
            }
        }

        return response()->json([
            'nombre' => $producto->nombre,
            'sdk' => $producto->sdk,
            'img' => $img
        ]);

        return $producto;
    }

}
