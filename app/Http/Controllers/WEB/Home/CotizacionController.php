<?php

namespace App\Http\Controllers\WEB\Home;

use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Categoria;
use App\Models\Cotizacion;
use App\Models\Producto;

use App\Mail\newCotizacion;
use App\Mail\UserNotification;

class CotizacionController extends Controller
{
    public function index()
    {
        $pageConfigs = [
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Inicio"], ['name' => "Carrito Cotizacion"]
        ];

        $categorias = Categoria::all();

        $productos = array();
        if(Cookie::get('carrito_cotizaciones') != null)
        {
            $items = json_decode(Cookie::get('carrito_cotizaciones'));

            foreach ($items as $item) 
            {
                $producto = Producto::where('SDK',$item)->first();
                $impresion = array();
                if(Str::contains($producto->metodos_impresion, ','))
                {
                    $metodos = Str::of($producto->metodos_impresion)->explode(',');
                    $impresion = $metodos;
                }else {
                    array_push($impresion,$producto->metodos_impresion);
                }

                $producto->impresiones = json_encode($impresion);
                array_push($productos,$producto);
            }
           
        }

        $total_productos = count($productos);
        
        return view('Home.cotizacion', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'categorias' => $categorias,
            'productos' => $productos,
            'total_productos' => $total_productos
        ]);

    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email',
            'fecha_deseable' => 'required',
            'pantones' => 'required',
            'tipografia' => 'required',
            'numero_tintas' => 'required',
            'producto_id' => 'required'
        ];

        $messages = [
            'nombre.required' => 'Es necesario asignar un nombre',
            'apellidos.required' => 'Es necesario asignar un apellido',
            'email.required' => 'Es necesario proporcionar un email para contactarnos',
            'fecha_deseable.required' => 'Es necesario indicar que dia quiere que se le entreguen los productos',
            'pantones.required' => 'Es necesario determinar los pantones de los productos',
            'tipografia.required' => 'Es necesario indicar la tipografia',
            'numero_tintas' => 'Es necesario indicar el numero de tintas',
            'producto_id' => 'Es necesario indicar el id de los productos'
        ];

        $this->validate($request,$rules,$messages);

        $cotizacion = new Cotizacion();
        $cotizacion->nombre = $request->nombre;
        $cotizacion->apellidos = $request->apellidos;
        $cotizacion->email = $request->email;
        $cotizacion->codigo_area = '+52';
        $cotizacion->celular = (int)Str::slug($request->celular,'');
        $cotizacion->comentarios = $request->comentarios;
        $medidas_deseables = array();
        $string = 'Sin definir';
        for($i = 0; $i < $request->total_productos; $i++)
        {
            array_push($medidas_deseables,$string);
        }

        $precios_pzas = array();
        $string = 0;
        for($i = 0; $i < $request->total_productos; $i++)
        {
            array_push($precios_pzas,$string);
        }
        
            

        $cotizacion->medidas_deseables = json_encode($medidas_deseables);
        $cotizacion->fecha_deseable = json_encode($request->fecha_deseable);
        $cotizacion->pantones = json_encode($request->pantones);
        $cotizacion->tipografia = json_encode($request->tipografia);
        $cotizacion->precio_pza = json_encode($precios_pzas);
        $cotizacion->precio_x_producto = json_encode($precios_pzas);
        $cotizacion->precio_total = 0;
        $cotizacion->precio_subtotal = 0;
        $cotizacion->mano_x_obra = 0;
        
        $cotizacion->numero_tintas = json_encode($request->numero_tintas);
        $cotizacion->forma_pago = 'Tarjeta';
        $cotizacion->numero_pzas = json_encode($request->numero_pzas);
        $cotizacion->productos_id = json_encode($request->producto_id);
        $cotizacion->metodos_impresion = json_encode($request->metodos_impresion);
        $cotizacion->total_productos = $request->total_productos;
        $cotizacion->calle = $request->calle;
        $cotizacion->cp = $request->cp;
        $cotizacion->no_ext = $request->no_ext;
        $cotizacion->estado = $request->estado;
        $cotizacion->colonia = $request->colonia;
        $cotizacion->ciudad = $request->ciudad;
        $cotizacion->status = 'Pendiente';
        $cotizacion->user_id = 1;

        if($request->archivos)
        {
            $files = $request->file('archivos');
            $array_img = array();
            $fileName = "";
            foreach ($files as $file) {
                $fileName = uniqid().$file->getClientOriginalName();  
                $path_logo = $file->storeAs(
                    'cotizaciones_logo',
                    $fileName,
                    'public'
                );
                array_push($array_img,$path_logo);   
            }
            $imgs = json_encode($array_img);
 
            $cotizacion->logo_img = $imgs;
            $cotizacion->img_name = $imgs;
            $cotizacion->save();

        }else{
            $cotizacion->logo_img = null;
            $cotizacion->img_name = null;
        }

        $cotizacion->save();

        setcookie('carrito_cotizaciones', NULL);
        $url = url('/').'/login';

        Mail::to('juan.alucard.02@gmail.com')
            ->cc(['alphapromos.rsociales@gmail.com','ventas@alphapromos.mx'])
            ->send(new newCotizacion($url,$cotizacion));
        
        Mail::to($cotizacion->email)     
            ->send(new UserNotification($cotizacion));

        return back()->with('success','La cotizacion se envio de forma exitosa!, nos pondremos en contacto con usted muy pronto.');
    }
}
