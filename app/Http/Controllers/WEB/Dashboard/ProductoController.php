<?php

namespace App\Http\Controllers\WEB\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Models\Categoria;
use App\Models\OrderProduct;

class ProductoController extends Controller
{
    public function index()
    {
        $innova = DB::table('products')->where('proveedor','Innova')->where('deleted_at',null)->count();
        $promoOpcion = DB::table('products')->where('proveedor','PromoOpcion')->where('deleted_at',null)->count();
        $vela = DB::table('products')->where('proveedor','DobleVela')->where('deleted_at',null)->count();
        $forpromo = DB::table('products')->where('proveedor','Forpromotional')->where('deleted_at',null)->count();

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
        $producto = Product::find($id);
        $categorias = Categoria::all();
        if($producto != null)
        {
            $imgs = json_decode($producto->images);
            return view('dashboard.productos.edit',[
                'imgs' => $imgs,
                'producto' => $producto,
                'categorias' => $categorias
            ]);
        }
    }

    public function update(Request $request, $id){
        $rules = [
            'nombre' =>       'required|string',
            'modelo' =>       'required|string',
            'categoria' =>    'required',
            'subcategoria' => 'required',
            'descripcion' =>  'required|string'
        ];

        $messages = [
            'nombre.required' => 'Es necesario un Nombre',
            'nombre.text' => 'Tipo de Nombre valido',
            'modelo.required' => 'Es necesario un Modelo',
            'modelo.text' => 'TIpo de modelo NO valido',
            'categoria.required' => 'Es necesario llenar este campo',
            'subcategoria.required' => 'Es necesario llenar este campo',
            'descripcion.required' => 'Es necesaria una Descripcion',
            'descripcion.text' => 'Tipo de descripcion NO valido',
        ];

        $this->validate($request, $rules, $messages);
        $producto = Product::find($id);
        $producto->nombre = $request->nombre;
        $producto->modelo = $request->modelo;
        $producto->categoria_id = $request->categoria;
        $producto->subcategoria_id = $request->subcategoria;
        $producto->descripcion = $request->descripcion;

        $producto->save();
        return back();
    }

    public function delete($id)
    {
        $producto = Product::find($id);

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

    public function create()
    {
        $categorias = Categoria::all();
        return view('dashboard.productos.create',[
            'categorias' => $categorias        
        ]);
    }

    public function store( Request $request)
    {
        $product = Product::find($request->addProductId); 
        $order = Order::find($request->addOrderId);

        $order_x_product = new OrderProduct();
        $order_x_product->order_id = $order->order_id;
        $order_x_product->product_id = $product->id;
        $order_x_product->name = $product->name;
        $order_x_product->name = $product->name;
        $order_x_product->printing_area = 'Sin definir';
        $order_x_product->pantone = $request->addPantone;
        $order_x_product->typography = $request->addTypography;
        $order_x_product->num_ink = (int) $request->addNoInk;
        $order_x_product->num_pzas = (int) $request->addNoPzas;
        $order_x_product->price_x_unid = (double) $request->addCostUnit;
        $order_x_product->printing_method = $request->addPrintingMethod;
        $order_x_product->provider = $product->proveedor;
        $order_x_product->save();

        return back()->with('success',"Producto agregado a la Cotización");
        

    }
}
