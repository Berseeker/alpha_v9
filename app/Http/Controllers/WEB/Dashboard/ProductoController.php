<?php

namespace App\Http\Controllers\WEB\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Order;
use App\Models\Product;
use App\Models\Categoria;
use App\Models\Subcategoria;
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
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'colors' => 'required',
            'details' => 'required',
            'printing_area' => 'required',
            'printing_methods' => 'required',
            'categoria' => 'required',
            'subcategoria' => 'required',
            'box_pieces' => 'required',
            'material' => 'required',
            'provider' => 'required'
        ];

        $messages = [
            'name.required' => 'Es necesario indicar el nombre de tu producto',
            'code.required' => 'Es necesario agregar un identificador unico',
            'colors.required' => 'Es necesario indicar los colores disponibles del producto',
            'details.required' => 'Es necesario indicar una descripcion para el producto',
            'printing_area' => 'Es necesario indicar el area de impresion que se tiene del producto',
            'categoria.required' => 'Es necesario indicar la categoria a la que pertenece el producto',
            'subcategoria.required' => 'Es necesario indicar la subcategoria a la que pertenece el producto',
            'box_pieces.required' => 'Es necesario indicar el numero de piezas que puede llevar una caja para shipping',
            'material.required' => 'Es necesario indicar el material del cual esta hecho el producto',
            'provider.required' => 'Es necesario indicar el proveedor al cual pertence el producto' 
        ];

        $this->validate($request, $rules, $messages);

        $product = new Product();
        $product->name = $request->name;
        $product->code = $request->code;
        $product->parent_code = $request->code . '_parent';
        $product->proveedor = trim($request->proveedor);
        $product->discount = 0;
        // Colors process
        $request_colors = explode(',',$request->colors);
        $colors = [];
        //We clean the array: whitespaces/empty values
        foreach ($request_colors as $color) {
            if ($color != '')
                array_push($colors, trim($color));
        }
        $product->colors = json_encode($colors);
        $product->details = trim($request->details);
        $product->printing_area = trim($request->printing_area);
        // Printing methods process
        $request_printing_methods = explode(',', $request->printing_methods);
        $printing_methods = [];
        // We clean the array: whitespaces/empty values
        foreach ($request_printing_methods as $method) {
            if ($method != '')
                array_push($printing_methods, trim($method));
        }
        $product->printing_methods = json_encode($printing_methods);
        // Category and Subcategory process
        $subcategoria = Subcategoria::find((int) $request->subcategoria);
        if ($subcategoria != null) {
            $product->subcategory = $subcategoria->nombre;
            $product->subcategoria_id = $subcategoria->id;
            $product->category = $subcategoria->categoria->nombre;
            $product->categoria_id = $subcategoria->categoria->id;
        } else {
            $product->subcategory = 'VARIOS';
            $product->subcategoria_id = 93;
            $product->category = 'ARTICULOS DE HOTELERÍA';
            $product->categoria_id = 20;
        }

        $product->box_pieces = $request->box_pieces;
        //Images process
        //Check if the request has files on it
        $imgs = [];
        if ($request->hasFile('images')) {
            foreach($request->images as $img)
            {
                $path = $img->path();
                $extension = $img->extension();
                $slug = Str::slug($product->name . ' ' . $product->proveedor, '_');
                $nameImg = $slug . '.' . $extension;

                if (!Storage::disk('doblevela_img')->exists($nameImg)) 
                {
                    Storage::disk('doblevela_img')->put($nameImg,$img);
                    array_push($imgs,$imageName);
                }
            }
        }
        $product->images = json_encode((empty($imgs)) ? null : $imgs);
        $product->material = trim($request->material);
        $product->custom = true;
        $product->search = $product->category . ', ' .$product->subcategory . ', ' . Str::upper(trim($product->name));
        $product->meta_keywords = $product->search;
        $product->save();


        return back()->with('success',"Producto agregado a la Cotización");
    }
}
