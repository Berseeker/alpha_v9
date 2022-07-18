<?php

namespace App\Http\Controllers\WEB\Dashboard;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Cotizacion;
use App\Models\Producto;
use App\Models\Venta;

use DateTime;
//para el manejo de archivos
use ZipArchive;
use File;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::all();

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['name' => "Cotizaciones"]
        ];

        return view('dashboard.cotizaciones.index',[
            'cotizaciones' => $cotizaciones,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function show($id)
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "/dashboard/cotizaciones", 'name' => "Cotizaciones"], ['name' => "Cotizacion"]
        ];

        $cotizacion = Cotizacion::find($id);

        $ids = json_decode($cotizacion->productos_id);
        $fechas_deseables = json_decode($cotizacion->fecha_deseable);
        $pantones = json_decode($cotizacion->pantones);
        $tipografia = json_decode($cotizacion->tipografia);
        $numero_tintas = json_decode($cotizacion->numero_tintas);
        $colores = json_decode($cotizacion->color);
        $num_pzas = json_decode($cotizacion->numero_pzas);
        
        $productos = DB::table('productos')
                    ->whereIn('id', $ids)
                    ->get();

        
        $items = array();
        $void = 0;
        foreach ($productos as $producto) 
        {
            $colors = json_decode($producto->color);
            $colores = '';
            $count = 0;
            foreach ($colors as $key => $color) 
            {
                if($count == 0)
                {
                    $colores = $colores.' '.$color;
                }
                else {
                    $colores = $colores.','.$color;
                }
                $count++;
            }
            $producto->colores = $colores;
            $producto->fecha_deseable = $fechas_deseables[$void];
            $producto->pantones = $pantones[$void];
            $producto->tipografia = $tipografia[$void];
            $producto->numero_tintas = $numero_tintas[$void];
            $producto->num_pzas = $num_pzas[$void];
            array_push($items,$producto);
            $void++;
        }


        return view('dashboard.cotizaciones.show',[
            'cotizacion' => $cotizacion,
            'productos' => $items,
            'breadcrumbs' => $breadcrumbs
        ]);
        
    }

    public function edit($id)
    {
        $cotizacion = Cotizacion::find($id);
        $productosAll = Producto::all();

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "/dashboard/show-cotizacion/".$cotizacion->id, 'name' => "Cotizacion - ".$cotizacion->id], ['name' => "Editando Cotizacion"]
        ];
        
        $ids = json_decode($cotizacion->productos_id);
        $fechas_deseables = json_decode($cotizacion->fecha_deseable);
        $pantones = json_decode($cotizacion->pantones);
        $tipografia = json_decode($cotizacion->tipografia);
        $numero_tintas = json_decode($cotizacion->numero_tintas);
        $colores = json_decode($cotizacion->color);
        $num_pzas = json_decode($cotizacion->numero_pzas);
        $medidas_deseables = json_decode($cotizacion->medidas_deseables);
        $precio_pza = json_decode($cotizacion->precio_pza);
        $metodos_impresion = ($cotizacion->metodos_impresion == null) ? null : json_decode($cotizacion->metodos_impresion);
        
        $productos = DB::table('productos')
                    ->whereIn('id', $ids)
                    ->get();

        
        $items = array();
        $void = 0;
        foreach ($productos as $producto) 
        {
            $colors = json_decode($producto->color);
            $colores = '';
            $count = 0;
            foreach ($colors as $key => $color) 
            {
                if($count == 0)
                {
                    $colores = $colores.' '.$color;
                }
                else {
                    $colores = $colores.','.$color;
                }
                $count++;
            }
            $impresion = null;
            if($metodos_impresion != null){
                if(array_key_exists($void,$metodos_impresion)){
                    $impresion = $metodos_impresion[$void];
                }
            }
            $producto->colores = $colores;
            $producto->fecha_deseable = $fechas_deseables[$void];
            $producto->pantones = $pantones[$void];
            $producto->tipografia = $tipografia[$void];
            $producto->numero_tintas = $numero_tintas[$void];
            $producto->num_pzas = $num_pzas[$void];
            $producto->medidas_deseables = $medidas_deseables[$void];
            $producto->precio_pza = $precio_pza[$void];
            $producto->impresion_metodo = $impresion;
            array_push($items,$producto);
            $void++;
        }

        return view('dashboard.cotizaciones.edit',[
            'breadcrumbs' => $breadcrumbs,
            'cotizacion' => $cotizacion,
            'productos' => $productosAll,
            'productos_cot' => $items
        ]);
        
    }

    public function update(Request $request,$id)
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


        $cotizacion = Cotizacion::find($id);
        /* Cliente */
        $cotizacion->nombre = $request->nombre;
        $cotizacion->apellidos = $request->apellidos;
        $cotizacion->email = $request->email;
        $cotizacion->celular = $request->celular;
        $cotizacion->comentarios = $request->comentarios;
        /* Productos */
        // = array();
        /*foreach ($request->fecha_deseable as $item) {
           
            $date = new DateTime($item);
            
            array_push($date_transformed,$date->format('Y-m-d'));
        }*/
        
        $cotizacion->medidas_deseables = json_encode($request->medidas_deseables);
        $cotizacion->fecha_deseable = json_encode($request->fecha_deseable);
        $cotizacion->pantones = json_encode($request->pantones);
        $cotizacion->tipografia = json_encode($request->tipografia);
        $cotizacion->numero_tintas = json_encode($request->numero_tintas);
        $cotizacion->numero_pzas = json_encode($request->cantidad_pzas);
        $cotizacion->productos_id = json_encode($request->producto_id);
        $cotizacion->metodos_impresion = json_encode($request->servicio_id);
        
        $precios_productos = array();
        $total_pzas = 0;
        for($i=0;$i < $request->total_productos; $i++)
        {
            $precio_pzas = $request->precio_pza[$i];
            $num_pzas = $request->cantidad_pzas[$i];
            $total_pzas = $total_pzas + $request->cantidad_pzas[$i];
            $precio_producto = (double)$precio_pzas * (double)$num_pzas;
            array_push($precios_productos,$precio_producto);
        }
        /* Precios */
        
        $cotizacion->precio_pza = json_encode($request->precio_pza);
        $cotizacion->precio_x_producto = json_encode($precios_productos);
        $cotizacion->precio_total = $request->precio_total;
        $cotizacion->precio_subtotal = $request->precio_subtotal;
        $cotizacion->mano_x_obra = $request->mano_x_obra;
        /* Billing */
        $cotizacion->forma_pago = $request->forma_pago;
        $cotizacion->total_productos = $request->total_productos;
        $cotizacion->calle = $request->calle;
        $cotizacion->cp = $request->cp;
        $cotizacion->no_ext = $request->no_ext;
        $cotizacion->estado = $request->estado;
        $cotizacion->colonia = $request->colonia;
        $cotizacion->ciudad = $request->ciudad;
        $cotizacion->status = $request->status;
        $cotizacion->user_id = Auth::user()->id;
        $cotizacion->save();

        if($request->status == 'Aprobada')
        {
            $prevVenta = Venta::where('cotizacion_id',$cotizacion->id)->first();
            if($prevVenta == null)
            {
                $venta = new Venta();
                $venta->cantidad_piezas = $total_pzas;
                $venta->venta_realizada = now();
                $venta->total = $request->precio_total;
                $venta->subtotal = $request->precio_subtotal;
                $venta->mano_obra = $request->mano_x_obra;
                $venta->status = 'Aprobada';
                $venta->cotizacion_id = $cotizacion->id;
                $venta->user_id = Auth::user()->id;
                $venta->save();
            }
            else {
                $prevVenta->cantidad_piezas = $total_pzas;
                $prevVenta->total = $request->precio_total;
                $prevVenta->subtotal = $request->precio_subtotal;
                $prevVenta->mano_obra = $request->mano_x_obra;
                $prevVenta->user_id = Auth::user()->id;
                if($prevVenta->isDirty())
                {
                    $prevVenta->venta_realizada = now();
                    $prevVenta->save();
                }
            }          
        }
        //$cotizacion->id
        //venta $cotizaion_id
        if($request->status == 'Pendiente' || $request->status == 'Cancelada' ){
            $preVenta = Venta::where('cotizacion_id', '=' , $cotizacion->id)->get();
            if(!$preVenta->isEmpty()){
                foreach($preVenta as $Venta){
                    $Venta->delete();
                }
            }

        }

        return back()->with('success','La cotizacion se actualizo de manera correcta');
        
    }

    public function download($id){
        
        $cotizacion = Cotizacion::find($id);
        $path = public_path('storage');
        $public = public_path();
        if($cotizacion->logo_img != NULL){

            $files = json_decode($cotizacion->logo_img);
            $zipname = uniqid().'assets.zip';
            $zip = new ZipArchive;
            $zip->open($public.'/assets/'.$zipname, ZipArchive::CREATE);
            foreach ($files as $file) {
                $zip->addFile($path.'/'.$file,$file);
            }
            $zip->close();
            
            return response()->download($public.'/assets/'.$zipname);
        }
        else{
            return back()->with('warning', 'No hay archivos adjuntos!');
        }
    }

    public function preview($id)
    {
        $cotizacion = Cotizacion::find($id);

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "/dashboard/show-cotizacion/".$cotizacion->id, 'name' => "Cotizacion - ".$cotizacion->id], ['name' => "Editando Cotizacion"]
        ];

        $ids = json_decode($cotizacion->productos_id);
        $num_pzas = json_decode($cotizacion->numero_pzas);
        $precio_pza = json_decode($cotizacion->precio_pza);

        $productos = DB::table('productos')
                    ->whereIn('id', $ids)
                    ->get();

        $items = array();
        $void = 0;
        foreach ($productos as $producto) 
        {
            $producto->num_pzas = $num_pzas[$void];
            $producto->precio_pza = $precio_pza[$void];
            $producto->precio_producto = (double)($num_pzas[$void] * $precio_pza[$void]);
            array_push($items,$producto);
            $void++;
        }

        return view('dashboard.cotizaciones.download',[
            'breadcrumbs' => $breadcrumbs,
            'cotizacion' => $cotizacion,
            'productos' => $items
        ]);
    }

    public function invoice_print($id)
    {
        $cotizacion = Cotizacion::find($id);

        $pageConfigs = ['pageHeader' => false];

        $ids = json_decode($cotizacion->productos_id);
        $num_pzas = json_decode($cotizacion->numero_pzas);
        $precio_pza = json_decode($cotizacion->precio_pza);

        $productos = DB::table('productos')
                    ->whereIn('id', $ids)
                    ->get();

        $items = array();
        $void = 0;
        foreach ($productos as $producto) 
        {
            $producto->num_pzas = $num_pzas[$void];
            $producto->precio_pza = $precio_pza[$void];
            $producto->precio_producto = (double)($num_pzas[$void] * $precio_pza[$void]);
            array_push($items,$producto);
            $void++;
        }

        return view('dashboard.cotizaciones.print', [
            'breadcrumbs' => $pageConfigs,
            'cotizacion' => $cotizacion,
            'productos' => $items
        ]);
    }
}

function invertDate($date_db){

    $explode_string = explode("-",$date_db);
    $month = 0;
    $day = 0;

    if($explode_string[1] == "01")
    $month = "Enero,";
    
    if($explode_string[1] == "02")
    $month = "Febero,";
    
    if($explode_string[1] == "03")
    $month = "Marzo,";
    
    if($explode_string[1] == "04")
    $month = "Abril";
    
    if($explode_string[1] == "05")
    $month = "Mayo,";
    
    if($explode_string[1] == "06")
    $month = "Junio,";
    
    if($explode_string[1] == "07")
    $month = "Julio,";
    
    if($explode_string[1] == "08")
    $month = "Agosto,";
    
    if($explode_string[1] == "09")
    $month = "Septiembre";
    
    if($explode_string[1] == "10")
    $month = "Octubre,";
    
    if($explode_string[1] == "11")
    $month = "Noviembre,";
    
    if($explode_string[1] == "12")
    $month = "Diciembre,";

    
    if($explode_string[2] == '01'){
        $day = "1";
    }
    else if($explode_string[2] == '02'){
        $day = "2";
    }
    
    else if($explode_string[2] == '03'){
        $day = "3";
    }

    else if($explode_string[2] == '04'){
        $day = "4";
    }
    else if($explode_string[2] == '05'){
        $day = "5";
    }
      
    else if($explode_string[2] == '06'){
        $day = "6";
    }
    
    else if($explode_string[2] == '07'){
        $day = "7";
    }

    else if($explode_string[2] == '08'){
        $day = "8";
    }
    
    else if($explode_string[2] == '09'){
        $day = "9";
    }
    else{
        $day = $explode_string[2];
    }
    
    $date = $day." ".$month." ".$explode_string[0];
    return $date;

}