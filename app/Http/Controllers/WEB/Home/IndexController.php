<?php

namespace App\Http\Controllers\WEB\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;

use App\Models\Categoria;
use App\Models\Subcategoria;

class IndexController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        $cont = 1;

        return view('welcome',[
            'categorias' => $categorias,
            'cont' => $cont
        ]);
    }

    public function showCategoria(Request $request,$slug)
    {

        $categoria = NULL;
        $slug_categoria = DB::table('slugs')->where('slug',$slug)->get();
        if(!$slug_categoria->isEmpty()){
 
            $categoria = Categoria::find($slug_categoria[0]->fk_id);
            $flag = 1;
        }
        $categorias = Categoria::all();
        $cont = 1;

        if($categoria == NULL){
            $productos = NULL;
            $total_items = 0;
            $flag = 0;
            
        }else{

            if($request->has('search_category') && $request->search_category != NULL){

                $string = $request->search_category;
                $productos = DB::table('productos')
                    ->where('categoria_id' ,'=', $categoria->id)
                    ->where('deleted_at' ,'=', NULL)
                    ->where(function($query) use ($string){
                        $query->where('nombre', 'LIKE', '%'.$string.'%');
                        $query->orWhere('descripcion', 'LIKE', '%'.$string.'%');
                    })
                    ->paginate(40);
            }else{
                $productos = Producto::where('categoria_id', '=', $categoria->id)->where('deleted_at' ,'=', NULL)->paginate(40);
            }

            $total_items = $productos->links()->paginator->total();

            if(count($productos) == 0)
                $flag=0;
        }
        

        return view('Home.categoria',[
            'pageConfigs' => $pageConfigs,
            'categoria' => $categoria,
            'productos' => $productos,
            'categorias' => $categorias,
            'cont' => $cont,
            'breadcrumbs' => $breadcrumbs,
            'total' => $total_items,
            'flag' => $flag
        ]);
    }





    public function showSubcategoria(Request $request,$slug){

        $pageConfigs = [
          'contentLayout' => "content-detached-left-sidebar",
          'bodyClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link'=>"dashboard-analytics",'name'=>"Home"],['link'=>"dashboard-analytics",'name'=>"eCommerce"], ['name'=>"Shop"]
        ];

        $subcategoria = NULL;
        $slug_subcategoria = DB::table('slugs')->where('slug',$slug)->get();
        if(!$slug_subcategoria->isEmpty()){
 
            $subcategoria = Subcategoria::find($slug_subcategoria[0]->fk_id);
            $flag = 1;
        }
        
        $categorias = Categoria::all();
        $cont = 1; 

        if($subcategoria == NULL){
            $productos = NULL;
            $total_items = 0;
            $flag = 0;
            $categoria = NULL;
            
        }else{

            $categoria = Categoria::find($subcategoria->categoria_id);

            if($request->has('search_category') && $request->search_category != NULL){

                $string = $request->search_category;
                $productos = DB::table('productos')
                    ->select(DB::raw('*'))
                    ->where('deleted_at' ,'=', NULL)
                    ->where('nombre', 'LIKE', "%{$string}%")
                    ->orWhere('descripcion', 'LIKE', "%{$string}%")
                    ->where('subcategoria_id','=',$string)
                    ->paginate(40);
            }else{
                $productos = Producto::where('subcategoria_id', '=', $subcategoria->id)->where('deleted_at' ,'=', NULL)->paginate(40);
            }

            $total_items = $productos->links()->paginator->total();

            if(count($productos) == 0)
                $flag=0;

        }
            
        return view('Home.subcategoria',[
            'pageConfigs' => $pageConfigs,
            'subcategoria' => $subcategoria,
            'productos' => $productos,
            'categorias' => $categorias,
            'cont' => $cont,
            'breadcrumbs' => $breadcrumbs,
            'total' => $total_items,
            'categoria' => $categoria,
            'flag' => $flag
        ]);
    }

    public function showProducto($slug){

        $pageConfigs = [
          'contentLayout' => "content-detached-left-sidebar",
          'bodyClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link'=>"dashboard-analytics",'name'=>"Home"],['link'=>"dashboard-analytics",'name'=>"eCommerce"], ['name'=>"Shop"]
        ];

        $producto = NULL;
        $slug_producto = DB::table('slugs')->where('slug',$slug)->get();
        if(!$slug_producto->isEmpty()){
            $producto = Producto::find($slug_producto[0]->fk_id);
        }
        $categorias = Categoria::all();
        $cont = 1;
        $area_impresion = NULL;
        
        if($producto == NULL){
            $area_impresion = "S/MEDIDAS_IMP";
            $productos_relacionados = NULL;
            $colores = NULL;
            $count_color = 0;
            $categoria = NULL;
            $images = NULL;
            $producto = new Producto();
            $producto->nombre = NULL;
            $producto->nickname = NULL;
            $producto->descripcion = NULL;
            $producto->piezas_caja = NULL;
            $producto->area_impresion = NULL;
            $producto->metodos_impresion = NULL;
            $producto->peso_caja = NULL;
            $producto->medidas_producto_general = "0x0";
            $producto->caja_master = "0x0x0 cms";

        }else{

            $images = json_decode($producto->images);
            $categoria = Categoria::find($producto->categoria_id);

            if($producto->area_impresion != "S/MEDIDAS_IMP"){
                $area_impresion = $producto->area_impresion;
            }
            $colores = json_decode($producto->color);
            $count_color = 0;
            $productos_relacionados = Producto::where('subcategoria_id', '=', $producto->subcategoria_id)->where('deleted_at' ,'=', NULL)->get();

        }


        
        return view('Home.detalles',[
            'producto' => $producto,
            'images' => $images,
            'categorias' => $categorias,
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'cont' => $cont,
            'area_impresion' => $area_impresion,
            'categoria' => $categoria,
            'colores' => $colores,
            'count_color' => $count_color,
            'productos_relacionados' => $productos_relacionados
        ]);

    }
}
