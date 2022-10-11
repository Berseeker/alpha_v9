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
        //$productos = DB::table('productos')->with('categoria')->get()->toJson();
        $productos = Producto::with('categoria')->where('deleted_at',null)->get()->toJson();
        
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
                $img = url('/'.$img);
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
