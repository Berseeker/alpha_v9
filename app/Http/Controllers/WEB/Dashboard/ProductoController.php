<?php

namespace App\Http\Controllers\WEB\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $innova = DB::table('productos')->where('proveedor','Innova')->where('deleted_at',null)->count();
        $promoOpcion = DB::table('productos')->where('proveedor','PromoOpcion')->where('deleted_at',null)->count();
        $vela = DB::table('productos')->where('proveedor','Doble Vela')->where('deleted_at',null)->count();
        $forpromo = DB::table('productos')->where('proveedor','Forpromotional')->where('deleted_at',null)->count();

        $pageConfigs = ['pageHeader' => false];
        return view('dashboard.productos.index',[
            'pageConfigs' => $pageConfigs,
            'innova' => $innova,
            'promoOpcion' => $promoOpcion,
            'vela' => $vela,
            'forpromo' => $forpromo
        ]);
    }

    public function edit($id)
    {
        $producto = Producto::find($id);
        if($producto != null)
        {
            $imgs = json_decode($producto->images);
            return view('dashboard.productos.edit',[
                'imgs' => $imgs,
                'producto' => $producto
            ]);
        }
    }

    public function delete($id)
    {
        $producto = Producto::find($id);

        if($producto != null)
        {
            $sku = $producto->SDK;
            $producto->delete();

            return back()->with('success','El producto con identificador '.$sku.' fue eliminado correctamente');
        }
        else {
            return back()->with('error','El producto seleccionado no pudo ser eliminado');
        }
    }
}
