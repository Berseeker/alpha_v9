<?php

namespace App\Http\Controllers\WEB\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Subcategoria;
use App\Models\Newsletter;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Product;

use App\Mail\newMessage;
use App\Models\Imagen;


class IndexController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        $cont = 1;
        $imagen = Imagen::all();

        return view('welcome',[
            'categorias' => $categorias,
            'cont' => $cont,
            'imagenes' => $imagen
        ]);
    }

    public function showCategoria(Request $request,$slug)
    {
 
        $categoria = NULL;
        $title = null;
        $cont = 1; 
        $total_items = 0;

        $slug_categoria = DB::table('slugs')->where('slug',$slug)->get();
        if(!$slug_categoria->isEmpty()){
 
            $categoria = Categoria::find($slug_categoria[0]->fk_id);
            $title = $categoria->nombre;
            $flag = 1;
        }
        $categorias = Categoria::all();

        if ($categoria == NULL) {
            $productos = NULL;
            $flag = 0;
            
        } else {

            if ($request->has('search_global'))
            {
                $title = Str::upper($request->search_global);
                $productos = Product::search($request->search_global)->get();
                $total_items = count($productos);
            } else {
                $productos = Product::where('categoria_id', '=', $categoria->id)->where('deleted_at' ,'=', NULL)->paginate(30);
                $total_items = $productos->links()->paginator->total();
            }

            if(count($productos) == 0)
                $flag=0;
        }

        
        $categoria->seo->update([
            'title' => 'AlphaPromos - ' . $categoria->nombre,
            'description' => 'Categoria ' . $categoria->nombre,
        ]);
           
        return view('Home.categoria',[
            'categoria' => $categoria,
            'productos' => $productos,
            'categorias' => $categorias,
            'title' => $title,
        ]);
    }


    public function showSubcategoria(Request $request,$slug)
    {

        $subcategoria = NULL;
        $title = null;
        $slug_subcategoria = DB::table('slugs')->where('slug','sub-'.$slug)->get();
        if(!$slug_subcategoria->isEmpty())
        {
            $subcategoria = Subcategoria::find($slug_subcategoria[0]->fk_id);
            $title = $subcategoria->nombre;
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

            if($request->has('search_global'))
            {
                $title = Str::upper($request->search_global);
                $productos = Product::search($request->search_global)->get();
                $total_items = count($productos);
            }else{
                $productos = Product::where('subcategoria_id', '=', $subcategoria->id)->where('deleted_at' ,'=', NULL)->paginate(40);
                $total_items = $productos->links()->paginator->total();
            }

            if(count($productos) == 0)
                $flag=0;

        }
        
        return view('Home.subcategoria',[
            'subcategoria' => $subcategoria,
            'productos' => $productos,
            'categorias' => $categorias,
            'categoria' => $categoria,
            'title' => $title
        ]);
    }

    public function showProducto($slug)
    {
        $producto = NULL;
        $title = null;
        $slug_producto = DB::table('slugs')->where('slug',$slug)->get();
        if(!$slug_producto->isEmpty()){
            $producto = Product::find($slug_producto[0]->fk_id);
            $title = $producto->name;
        }


        $categorias = Categoria::all();     
        $categoria = Categoria::find($producto->categoria_id);
        $area_impresion = NULL; 

        if($producto->printing_area != "S/MEDIDAS_IMP"){
            $area_impresion = $producto->printing_area;
        }

        if ($producto->printing_area == NULL) {
            $area_impresion = 'Sin especificar';
        }

        $productos_relacionados = Product::where('subcategoria_id', '=', $producto->subcategoria_id)->where('deleted_at' ,'=', NULL)->limit(10)->get();

        $metodos_impresion = '';
        $methods = json_decode($producto->printing_methods);
        $cont = 0;
        if ($methods != null) {
            foreach ($methods as $item) {
                if ($cont == 0) {
                    $metodos_impresion = $metodos_impresion . $item;
                } else {
                    $metodos_impresion = $metodos_impresion . ',' . $item;
                }
                $cont++;
            }
        }
        

        $colors = NULL;
        $cont_colors = count(json_decode($producto->colors));
        if ($cont_colors > 0) {
            $colors = json_decode($producto->colors);
        }
        
        return view('Home.producto',[
            'title' => $title,
            'categorias' => $categorias,
            'categoria' => $categoria,
            'producto' => $producto,
            'productos_relacionados' => $productos_relacionados,
            'area_impresion' => $area_impresion,
            'metodos_impresion' => $metodos_impresion,
            'colors' => $colors
        ]);

    }

    public function busqueda(Request $request)
    {
        $pageConfigs = [
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "eCommerce"], ['name' => "Shop"]
        ];

        $categoria = NULL;
        $title = null;
        $cont = 1; 
        $total_items = 0;
        $flag = 1;

        $categorias = Categoria::all();

        if($request->has('search_global'))
        {
            $title = Str::upper($request->search_global);
            $productos = Product::where('nombre','LIKE','%'.$request->search_global.'%')->orWhere('descripcion','LIKE','%'.$request->search_global.'%')->get();
            $total_items = count($productos);
        }


        if(count($productos) == 0)
            $flag=0;
        
        
        return view('Home.busqueda',[
            'pageConfigs' => $pageConfigs,
            'productos' => $productos,
            'categorias' => $categorias,
            'breadcrumbs' => $breadcrumbs,
            'total' => $total_items,
            'flag' => $flag,
            'title' => $title,
            'cont' => $cont
        ]);
    }

    public function contacto(Request $request)
    {
        $categorias = Categoria::all();

        return view('Home.contacto', [
            'categorias' => $categorias
        ]);  
    }

    public function sendMessage(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'email' => 'required',
            'celular' => 'required',
            'g-recaptcha-response' => 'recaptcha'
        ];

        $messages = [
            'nombre.required' => 'Es necesario indicar un nombre',
            'email.required' => 'Es necesario dejar un email',
            'celular.required' => 'Es necesario dejar un numero de contacto',
            'g-recaptcha-response' => 'Es necesario llenar este'

        ];

        $this->validate($request,$rules,$messages);


        Mail::to('juan.alucard.02@gmail.com')
            ->cc(['alphapromos.rsociales@gmail.com','ventas@alphapromos.mx'])
            ->send(new newMessage($request->nombre,$request->email,$request->celular,$request->comentarios));

        return back()->with('success','El mensaje se envio correctamente');
    }

    public function servicios()
    {
        $categorias = Categoria::all();
        $pageConfigs = [
          'contentLayout' => "content-detached-left-sidebar",
          'bodyClass' => 'ecommerce-application',
        ];

        return view('Home.servicios',[
            'pageConfigs' => $pageConfigs,
            'categorias' => $categorias,
        ]);
    }

    public function newsletter(Request $request) {

        $prev = Newsletter::where('email', $request->news_email)->first();
        if ($prev != null) {
            return response()->json([
                'status' => 'error',
                'msg' => 'El email ya se encuentra registrado.'
            ]);
        }

        $newsletter = new Newsletter();
        $newsletter->email = $request->news_email;
        $newsletter->save();

        return response()->json([
            'status' => 'success',
            'msg' => 'El email se agrego correctamente.'
        ]);
    }
}
