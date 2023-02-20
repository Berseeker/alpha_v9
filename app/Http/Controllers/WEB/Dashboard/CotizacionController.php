<?php

namespace App\Http\Controllers\WEB\Dashboard;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Order;
use App\Models\Venta;

use DateTime;
//para el manejo de archivos
use ZipArchive;
use File;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Order::all();

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Dashboard"], ['name' => "Cotizaciones"]
        ];

        return view('dashboard.cotizaciones.index',[
            'cotizaciones' => $cotizaciones,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function show($id)
    {
        $breadcrumbs = [
            ['link' => "/home", 'name' => "Dashboard"], ['link' => "/dashboard/cotizaciones", 'name' => "Cotizaciones"], ['name' => "Cotizacion"]
        ];

        $order = Order::find($id);
        $order_x_products = OrderProduct::where('order_id', $order->order_id)->get();

        return view('dashboard.cotizaciones.show',[
            'order' => $order,
            'order_x_products' => $order_x_products,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function edit($id)
    {
        $order = Order::find($id);

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Dashboard"], ['link' => "/dashboard/show-cotizacion/", 'name' => "Cotizacion"], ['name' => "Order - " . $order->name . ' ' . $order->lastname ]
        ];

        $products = Product::all();
        $order_x_products = OrderProduct::where('order_id',$order->order_id)->get();

        return view('dashboard.cotizaciones.edit',[
            'breadcrumbs' => $breadcrumbs,
            'order' => $order,
            'products' => $products,
            'order_x_products' => $order_x_products
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


        $cotizacion = Order::find($id);
        /* Cliente */
        $cotizacion->nombre = $request->nombre;
        $cotizacion->apellidos = $request->apellidos;
        $cotizacion->email = $request->email;
        $cotizacion->celular = $request->celular;
        $cotizacion->comentarios = $request->comentarios;
        /* Productos */  
        $cotizacion->medidas_deseables = json_encode($request->medidas_deseables);
        $cotizacion->fecha_deseable = json_encode($request->fecha_deseable);
        $cotizacion->pantones = json_encode($request->pantones);
        $cotizacion->tipografia = json_encode($request->tipografia);
        $cotizacion->numero_tintas = json_encode($request->numero_tintas);
        $cotizacion->numero_pzas = json_encode($request->cantidad_pzas);
        $cotizacion->productos_id = json_encode($request->producto_id);
        $cotizacion->metodos_impresion = json_encode($request->servicio_id);
        $cotizacion->tax = $request->tax;
        
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
                $venta->total = ($request->precio_total == null) ? 0 : $request->precio_total;
                $venta->subtotal = ($request->precio_subtotal == null) ? 0 : $request->precio_subtotal;
                $venta->mano_obra = ($request->mano_x_obra == null) ? 0 : $request->mano_x_obra;
                $venta->status = 'Aprobada';
                $venta->cotizacion_id = $cotizacion->id;
                $venta->user_id = Auth::user()->id;
                $venta->save();
            }
            else {
                $prevVenta->cantidad_piezas = $total_pzas;
                $prevVenta->total = ($request->precio_total == null) ? 0 : $request->precio_total;
                $prevVenta->subtotal = ($request->precio_subtotal == null) ? 0 : $request->precio_subtotal;
                $prevVenta->mano_obra = ($request->mano_x_obra == null) ? 0 : $request->mano_x_obra;
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

    public function updateQuick(Request $request)
    {
 
        $cotizacion = Order::find((int) $request->cotizacion_id);
        $cotizacion->status = $request->estatus;
        $cotizacion->save();

        if($request->estatus == 'Aprobada')
        {
            $prevVenta = Venta::where('cotizacion_id',$cotizacion->id)->first();
            if($prevVenta == null)
            {
                $venta = new Venta();
                $venta->cantidad_piezas = $cotizacion->total_productos;
                $venta->venta_realizada = now();
                $venta->total = ($request->precio_total == null) ? 0 : $request->precio_total;
                $venta->subtotal = ($request->precio_subtotal == null) ? 0 : $request->precio_subtotal;
                $venta->mano_obra = ($request->mano_x_obra == null) ? 0 : $request->mano_x_obra;
                $venta->status = 'Aprobada';
                $venta->cotizacion_id = $cotizacion->id;
                $venta->user_id = Auth::user()->id;
                $venta->save();
            }
            else {
                $prevVenta->cantidad_piezas = $cotizacion->total_productos;
                $prevVenta->total = ($request->precio_total == null) ? 0 : $request->precio_total;
                $prevVenta->subtotal = ($request->precio_subtotal == null) ? 0 : $request->precio_subtotal;
                $prevVenta->mano_obra = ($request->mano_x_obra == null) ? 0 : $request->mano_x_obra;
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
        if($request->estatus == 'Pendiente' || $request->estatus == 'Cancelada' ){
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
        
        $cotizacion = Order::find($id);
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
        $cotizacion = Order::find($id);

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Dashboard"], ['link' => "/dashboard/show-cotizacion/".$cotizacion->id, 'name' => "Cotizacion - ".$cotizacion->id], ['name' => "Editando Cotizacion"]
        ];

        $ids = json_decode($cotizacion->productos_id);
        $num_pzas = json_decode($cotizacion->numero_pzas);
        $precio_pza = json_decode($cotizacion->precio_pza);

        $productos = DB::table('products')
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
        $cotizacion = Order::find($id);

        $pageConfigs = ['pageHeader' => false];

        $ids = json_decode($cotizacion->productos_id);
        $num_pzas = json_decode($cotizacion->numero_pzas);
        $precio_pza = json_decode($cotizacion->precio_pza);

        $productos = DB::table('products')
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

    public function deleteOrderProduct($order_id, $product_id)
    {
        $order = Order::find($order_id);
        $product = Product::find($product_id);
        $order_x_product = OrderProduct::where('order_id', $order->order_id)->where('product_id', $product->id)->first();
        $order_x_product->delete();

        return back()->with('success',"Producto elimnado de la cotización.");
    }

    public function invoice($order_id)
    {
        $order = Order::find($order_id);
        $order_x_products = OrderProduct::where('order_id', $order->order_id)->get();

        $client = new Party([
            'name'          => 'Blanca Morales',
            'phone'         => $order->code_area.' '.$order->phone,
            'custom_fields' => [
                'email'        => 'ventas@alphapromos.mx',
                'business id' => '365#GG',
            ],
        ]);

        $customer = new Party([
            'name'          => $order->name .' '.$order->lastname,
            'phone'         => $order->code_area.' '.$order->phone,
            'code'          => '#22663214',
            'custom_fields' => [
                'email' => $order->email,
                'direccion' => $order->city .', '. $order->state .', '. $order->address,
                'cp' => $order->cp
            ],
        ]);

        $items = array();
        foreach ($order_x_products as $key => $order_x_product) {
            array_push($items, (new InvoiceItem())
                ->img($order_x_product->product->preview)
                ->title($order_x_product->name)
                ->description($order_x_product->product->details)
                ->pricePerUnit(20)
                ->quantity($order->total_products)
                ->tax(6.4)
                ->discount(0)
            );
        }

        $notes = [
            'Forma de pago: 30 días',
            'Tiempo de Entrega: 14 días hábiles',
            'LOGOTIPOS CONVERTIDOS EN CURVAS, TIPOGRAFÍA, PANTONES A TRABAJAR',
        ];
        
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('Cotización - '. $order->identifier)
            ->series('BIG')
            // ability to include translated invoice status
            // in case it was paid
            ->status('PENDIENTE')
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now())
            ->dateFormat('Y/m/d')
            ->payUntilDays(14)
            ->currencySymbol('$')
            ->currencyCode('MXN')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename('invoice_' . $order->identifier . Str::slug($order->name .' '. $order->lastname, '_'))
            ->addItems($items)
            ->vatTax('Precios más 16% de I.V.A. incluye flete Guadalajara.')
            ->notes($notes)
            ->logo(public_path('imgs/v3/logos/logo_alpha.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link
        // And return invoice itself to browser or have a different view
        return $invoice->stream();
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