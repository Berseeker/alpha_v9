<?php

namespace App\Http\Controllers\WEB\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\Categoria;

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
        $producto = Producto::find($id);
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

    public function create()
    {
        $categorias = Categoria::all();
        return view('dashboard.productos.create',[
            'categorias' => $categorias        
        ]);
    }

    public function store( Request $request){
        $rules = [
            'nombre' =>             'required',
            'modelo'=>              'required',
            'SDK'=>                 'required',
            'color'=>               'required',
            'proveedor'=>           'required',
            'metodo_impresion'=>    'required',
            'categoria'=>          'required',
            'subcategoria'=>        'required',
            'descripcion'=>         'required',
        ];

        $messages = [
            'nombre.required' => 'Es necesario poner un nombre',
            'modelo.required' => 'Es necesario poner un modelo',
            'SDK.required' => 'Es necesario poner un SDK',
            'color.required' => 'Es necesario poner un color',
            'proveedor.required' => 'Es necesario poner un proveedor',
            'metodo_impresion.required' => 'Es necesario poner un metodo de impresion',
            'categoria.required' => 'Es necesario poner una categoria',
            'subcategoria.required' => 'Es necesario poner una subcategoria',
            'descripcion.required' => 'Es necesario poner una descripcion'
        ];
        
        $this->validate($request, $rules, $messages);
        $path = []; 
        $colores = explode(",",$request->color);
        if($request->has('nueva_imagen')){
            foreach($request->nueva_imagen as $imagen){
                $path[] = $imagen->store('public/productos');
            }  
        }

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->modelo = $request->modelo;
        $producto->images = ($request->has('nueva_imagen')) ? json_encode($path) : null;
        $producto->SDK = $request->SDK;
        $producto->color = json_encode($colores);
        $producto->proveedor = $request->proveedor;
        $producto->metodos_impresion = $request->metodo_impresion;
        $producto->categoria_id = $request->categoria;
        $producto->subcategoria_id = $request->subcategoria;
        $producto->descripcion = $request->descripcion;

        $producto->save();
        return back()->with('success',"Producto Creado");
        

    }
}
