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
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Product;

use App\Mail\newMessage;
use App\Models\Imagen;

use SEOMeta;
use OpenGraph;
use JsonLd;
use Twitter;


class IndexController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        $cont = 1;
        $imagen = Imagen::all();

        SEOMeta::setTitle('AlphaPromos');
        SEOMeta::setDescription('Pagina de articulos Promocionales');
        SEOMeta::setCanonical('https://alphapromos.mx');

        OpenGraph::setDescription('Pagina de articulos Promocionales');
        OpenGraph::setTitle('AlphaPromos');
        OpenGraph::setUrl('https://alphapromos.mx');
        OpenGraph::addProperty('type', 'articulos');

        Twitter::setTitle('AlphaPromos');
        Twitter::setSite('@alphapromos');

        JsonLd::setTitle('AlphaPromos');
        JsonLd::setDescription('Pagina de articulos Promocionales');
        //JsonLd::addImage('https://laravelcode.com/frontTheme/img/logo.png');


        return view('welcome',[
            'categorias' => $categorias,
            'cont' => $cont,
            'imagenes' => $imagen
        ]);
    }

    public function showCategoria(Request $request,$slug)
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

        $slug_categoria = DB::table('slugs')->where('slug',$slug)->get();
        if(!$slug_categoria->isEmpty()){
 
            $categoria = Categoria::find($slug_categoria[0]->fk_id);
            $title = $categoria->nombre;
            $flag = 1;
        }
        $categorias = Categoria::all();
        if($categoria == NULL){
            $productos = NULL;
            $flag = 0;
            
        }else{

            if($request->has('search_global'))
            {
                $title = Str::upper($request->search_global);
                $productos = Producto::search($request->search_global)->get();
                $total_items = count($productos);
            }else{
                $productos = Producto::where('categoria_id', '=', $categoria->id)->where('deleted_at' ,'=', NULL)->paginate(40);
                $total_items = $productos->links()->paginator->total();
            }


            if(count($productos) == 0)
                $flag=0;
        }

        SEOMeta::setTitle('Categoria - '.$title);
        SEOMeta::setDescription('Articulos que pertenecen a la categoria '.$title);
        SEOMeta::setCanonical('https://alphapromos.mx/');

        OpenGraph::setDescription('Articulos que pertenecen a la categoria '.$title);
        OpenGraph::setTitle('Categoria - '.$title);
        OpenGraph::setUrl('https://alphapromos.mx/');
        OpenGraph::addProperty('type', 'categoria');

        Twitter::setTitle('Categoria - '.$title);
        Twitter::setSite('@alphapromos');

        JsonLd::setTitle('Categoria - '.$title);
        JsonLd::setDescription('Articulos que pertenecen a la categoria '.$title);
        //JsonLd::addImage('https://laravelcode.com/frontTheme/img/logo.png');

        
        return view('Home.categoria',[
            'pageConfigs' => $pageConfigs,
            'categoria' => $categoria,
            'productos' => $productos,
            'categorias' => $categorias,
            'breadcrumbs' => $breadcrumbs,
            'total' => $total_items,
            'flag' => $flag,
            'title' => $title,
            'cont' => $cont
        ]);
    }


    public function showSubcategoria(Request $request,$slug)
    {
        $pageConfigs = [
          'contentLayout' => "content-detached-left-sidebar",
          'bodyClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link'=>"dashboard-analytics",'name'=>"Home"],['link'=>"dashboard-analytics",'name'=>"eCommerce"], ['name'=>"Shop"]
        ];

        $subcategoria = NULL;
        $title = null;
        $slug_subcategoria = DB::table('slugs')->where('slug',$slug)->get();
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
                $productos = Producto::search($request->search_global)->get();
                $total_items = count($productos);
            }else{
                $productos = Producto::where('subcategoria_id', '=', $subcategoria->id)->where('deleted_at' ,'=', NULL)->paginate(40);
                $total_items = $productos->links()->paginator->total();
            }

            if(count($productos) == 0)
                $flag=0;

        }

        SEOMeta::setTitle('Subcategoria - '.$title);
        SEOMeta::setDescription('Articulos que pertenecen a la subcategoria '.$title);
        SEOMeta::setCanonical('https://alphapromos.mx/');

        OpenGraph::setDescription('Articulos que pertenecen a la subcategoria '.$title);
        OpenGraph::setTitle('Subcategoria - '.$title);
        OpenGraph::setUrl('https://alphapromos.mx/');
        OpenGraph::addProperty('type', 'subcategoria');

        Twitter::setTitle('Subcategoria - '.$title);
        Twitter::setSite('@alphapromos');

        JsonLd::setTitle('Subcategoria - '.$title);
        JsonLd::setDescription('Articulos que pertenecen a la Subcategoria '.$title);
        //JsonLd::addImage('https://laravelcode.com/frontTheme/img/logo.png');
            
        return view('Home.subcategoria',[
            'pageConfigs' => $pageConfigs,
            'subcategoria' => $subcategoria,
            'productos' => $productos,
            'categorias' => $categorias,
            'cont' => $cont,
            'breadcrumbs' => $breadcrumbs,
            'total' => $total_items,
            'categoria' => $categoria,
            'flag' => $flag,
            'title' => $title
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
        $title = null;
        $slug_producto = DB::table('slugs')->where('slug',$slug)->get();

        if(!$slug_producto->isEmpty()){
            $producto = Producto::find($slug_producto[0]->fk_id);
            $title = $producto->nombre;
        }
        $categorias = Categoria::all();
        $cont = 1;
        $area_impresion = NULL;
        
        //dd($producto, $slug, $slug_producto);
        //$images = json_decode($producto->images);
        $categoria = Categoria::find($producto->categoria_id);

        if($producto->area_impresion != "S/MEDIDAS_IMP"){
            $area_impresion = $producto->area_impresion;
        }

        $productos_relacionados = Producto::where('subcategoria_id', '=', $producto->subcategoria_id)->where('deleted_at' ,'=', NULL)->limit(10)->get();

        $colores = json_decode($producto->colors);
        $count_color = 0;
        $images_collection = array();
        if( $producto->images != NULL)
        {
            foreach (json_decode($producto->images) as $img) {
                $image = $img;
                if(!Str::contains($img,['https','http']))
                {
                    $image = url('/'.$img);
                }

                array_push($images_collection,$image);
            }
        }

        SEOMeta::setTitle('Producto - '.$producto->nombre);
        SEOMeta::setDescription($producto->descripcion);
        SEOMeta::addMeta('producto:published_time', $producto->created_at->toW3CString(), 'property');
        SEOMeta::addKeyword($producto->meta_keywords);

        OpenGraph::setDescription($producto->descripcion);
        OpenGraph::setTitle($producto->name);
        OpenGraph::setUrl('https://alphapromos.mx/producto/ '.$slug_producto);
        OpenGraph::addProperty('type', 'producto');
        OpenGraph::addProperty('locale', 'es');
        OpenGraph::addImage($images_collection[0]);

        Twitter::setTitle($producto->nombre);
        Twitter::setSite('@alphapromos');
        
        JsonLd::setTitle($producto->nombre);
        JsonLd::setDescription($producto->descripcion);
        JsonLd::setType('Producto');
        JsonLd::addImage($images_collection[0]);

        
        return view('Home.producto',[
            'title' => $title,
            'categorias' => $categorias,
            'cont' => $cont,
            'producto' => $producto,
            'colores' => $colores,
            'count_color' => $count_color,
            'productos_relacionados' => $productos_relacionados
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
            $productos = Producto::where('nombre','LIKE','%'.$request->search_global.'%')->orWhere('descripcion','LIKE','%'.$request->search_global.'%')->get();
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
        $pageConfigs = [
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Inicio"], ['name' => "Mandanos un mensaje"]
        ];

        $categorias = Categoria::all();

        
        SEOMeta::setTitle('Contacto');
        SEOMeta::setDescription('Formulario de contacto para quejas o sugerencias');
        SEOMeta::setCanonical('https://alphapromos.mx/');

        OpenGraph::setDescription('Formulario de contacto para quejas o sugerencias');
        OpenGraph::setTitle('Contacto');
        OpenGraph::setUrl('https://alphapromos.mx/');
        OpenGraph::addProperty('type', 'contacto');

        Twitter::setTitle('Contacto');
        Twitter::setSite('@alphapromos');

        JsonLd::setTitle('Contacto');
        JsonLd::setDescription('Formulario de contacto para quejas o sugerencias');
        //JsonLd::addImage('https://laravelcode.com/frontTheme/img/logo.png');
        
        return view('Home.contacto', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
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

        SEOMeta::setTitle('Servicios');
        SEOMeta::setDescription('Tipos de servicios disponibles para los clientes');
        SEOMeta::setCanonical('https://alphapromos.mx/');

        OpenGraph::setDescription('Tipos de servicios disponibles para los clientes');
        OpenGraph::setTitle('Servicios');
        OpenGraph::setUrl('https://alphapromos.mx/');
        OpenGraph::addProperty('type', 'servicios');

        Twitter::setTitle('Servicios');
        Twitter::setSite('@alphapromos');

        JsonLd::setTitle('Servicios');
        JsonLd::setDescription('Tipos de servicios disponibles para los clientes');
        //JsonLd::addImage('https://laravelcode.com/frontTheme/img/logo.png');

        return view('Home.servicios',[
            'pageConfigs' => $pageConfigs,
            'categorias' => $categorias,
            'cont' => 1
        ]);
    }

}
