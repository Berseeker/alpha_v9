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
use App\Models\InvoiceOrder;
use App\Models\Shippment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Order;
use App\Models\Sale;

use DateTime;
//para el manejo de archivos
use ZipArchive;
use File;

class CotizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $invoice = InvoiceOrder::where('order_id', $order->order_id)->first();

        return view('dashboard.cotizaciones.show',[
            'order' => $order,
            'order_x_products' => $order_x_products,
            'breadcrumbs' => $breadcrumbs,
            'invoice' => $invoice
        ]);
    }

    public function edit($id)
    {
        $order = Order::find($id);

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Dashboard"], ['link' => "/dashboard/show-cotizacion/" . $order->order_id, 'name' => "Cotizacion"], ['name' => "Order - " . $order->name . ' ' . $order->lastname ]
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

    public function editInvoice($order_id)
    {
        $order = Order::find($order_id);
        $invoice = InvoiceOrder::where('order_id', $order->order_id)->first();

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Dashboard"], ['link' => "/dashboard/show-cotizacion/". $order->order_id, 'name' => "Cotizacion"], ['name' => "Order - " . $order->name . ' ' . $order->lastname ]
        ];

        return view('dashboard.cotizaciones.edit_invoice',[
            'breadcrumbs' => $breadcrumbs,
            'order' => $order,
            'invoice' => $invoice
        ]);

    }

    public function update(Request $request,$order_id)
    {
        $rules = [];
        $messages = [];

        if ($request->filled('product_id')) {
            $rules = [
                'pantone' => 'required',
                'printing_method' => 'required',
                'num_pzas' => 'required',
                'num_ink' => 'required',
                'price_x_unid' => 'required',
            ];

            $messages = [
                'pantone.required' => 'Es necesario poner un pantone',
                'printing_method.required' => 'Indica un tipo de impresion',
                'num_pzas.required' => 'Indica el numero de pzas de este producto',
                'num_ink.required' => 'Indica el numero de tintas',
                'price_x_unid.required' => 'Indica el precio por pza',
            ];
        } else {

            $rules = [
                'order_status' => 'required',
                'name' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'deadline' => 'required',
                'phone' => 'required',
                'country' => 'required',
                'state' => 'required',
                'cp' => 'required',
                'no_ext' => 'required',
                'address' => 'required',
            ];

            $messages = [
                'order_status.required' => 'Es necesario indicar el status de la cotizacion',
                'name.required' => 'Es necesario indicar el nombre del cliente',
                'lastname.required' => 'Es necesario asignar el apellido del cliente',
                'email.required' => 'Es necesario proporcionar un email para contactarnos',
                'deadline.required' => 'Es necesario indicar que dia quiere que se le entreguen los productos',
                'phone.required' => 'Indica un numero de contacto con el cliente',
                'country.required' => 'Indica el Pais donde se hara el delivery',
                'state.required' => 'Es necesario indicar el estado del Pais',
                'cp.required' => 'Es necesario indicar el CP del domicilio',
                'no_ext.required' => 'Es necesario indicar el numero exterior del domicilio',
                'address.required' => 'Es necesario indicar la direccion del domicilio',
            ];

        }

        $this->validate($request,$rules,$messages);

        $order = Order::find($order_id);

        if ($request->filled('product_id')) {
            $order_x_product = OrderProduct::where('order_id', $order->order_id)->where('product_id', $request->product_id)->first();
            if ($order_x_product != null) {
                $order_x_product->pantone = $request->pantone;
                $order_x_product->typography = $request->typography;
                $order_x_product->num_ink = (int) $request->num_ink;
                $order_x_product->num_pzas = (int) $request->num_pzas;
                $order_x_product->price_x_unid = (double) $request->price_x_unid;
                $order_x_product->printing_method = $request->printing_method;
                if ($order_x_product->isDirty()) {
                    $order_x_product->update();
                }
            }
        } else {
            $order->name = $request->name;
            $order->lastname = $request->lastname;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->country = $request->country;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->address = $request->address;
            $order->cp = $request->cp;
            $order->ext_num = $request->no_ext;
            $order->deadline = $request->deadline;
            if ($request->filled('comments')) {
                $order->comments = $request->comments;
            }
            $order->user_id = Auth::user()->id;
            $order->order_status = $request->order_status;
            $order->update();
        }

        if($request->order_status == 'APPROVED')
        {
            $prevVenta = Sale::where('order_id',$order->order_id)->first();
            if($prevVenta == null)
            {
                $payment = Payment::where('order_id', $order->order_id)->first();
                $shippment = Shippment::where('order_id', $order->order_id)->first();
                $sale = new Sale();
                $sale->order_id = $order->order_id;
                $sale->payment_id = $payment->id;
                $sale->shippment_id = $shippment->id;
                $sale->user_id = Auth::user()->id;
                $sale->save();
            }
        }

        if($request->order_status == 'CANCEL' || $request->status == 'PENDANT' ){
            $preVenta = Sale::where('order_id', '=' , $order->order_id)->get();
            if(!$preVenta->isEmpty()){
                foreach($preVenta as $Venta){
                    $Venta->delete();
                }
            }

        }

        return back()->with('success','La cotizacion se actualizo de manera correcta');

    }

    public function updateInvoice(Request $request, $order_id)
    {
        $rules = [
            'payment_days' => 'required',
            'deliver_days' => 'required',
            'place' => 'required'
        ];

        $messages = [
            'payment_days.required' => 'Es necesario indicar el plazo de dias para pagar el invoice',
            'deliver_days.required' => 'Es necesario indicar el plazo de dias hábiles para la entrega de productos',
            'place.required' => 'Es necesario indicar el lugar donde se hara la entrega de productos'
        ];

        $this->validate($request, $rules, $messages);

        $order = Order::find($order_id);

        $invoice = InvoiceOrder::where('order_id', $order->order_id)->first();
        $invoice->payment_days = $request->payment_days;
        $invoice->deliver_days = $request->deliver_days;
        $invoice->place = $request->place;
        $invoice->user_id = Auth::user()->id;
        $invoice->folio = $request->folio;
        $invoice->update();

        return back()->with('success', 'El invoice se actualizó correctamente.');
    }

    public function updateQuick(Request $request)
    {

        $order = Order::where('order_id', $request->cotizacion_id)->first();
        $order->order_status = $request->estatus;
        $order->save();

        $payment = Payment::where('order_id', $order->order_id)->first();
        $shippment = Shippment::where('order_id', $order->order_id)->first();

        if($request->estatus == 'APPROVED')
        {
            $prevVenta = Sale::where('order_id',$order->id)->first();
            if($prevVenta == null)
            {
                $sale = new Sale();
                $sale->order_id = $order->order_id;
                $sale->payment_id = $payment->id;
                $sale->shippment_id = $shippment->id;
                $sale->user_id = Auth::user()->id;
                $sale->save();
            }
        }

        if($request->estatus == 'Pendiente' || $request->estatus == 'Cancelada' ){
            $preVenta = Sale::where('order_id', '=' , $order->order_id)->get();
            if(!$preVenta->isEmpty()){
                foreach($preVenta as $Venta){
                    $Venta->delete();
                }
            }

        }

        return back()->with('success','La cotizacion se actualizo de manera correcta');

    }

    public function download($id)
    {
        $order = Order::find($id);
        $path = public_path('storage');
        $public = public_path();
        if($order->file_path != NULL){

            //$files = json_decode($order->file_path);
            $zipname = uniqid().'assets.zip';
            $zip = new ZipArchive;
            $zip->open($public.'/assets/'.$zipname, ZipArchive::CREATE);
           // foreach ($files as $file) {
                $zip->addFile($path.'/'.$order->file_path,$order->file_path);
            //}
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
        $invoice = InvoiceOrder::where('order_id', $order->order_id)->first();

        $client = new Party([
            'name'          => Auth::user()->name,
            'phone'         => (Auth::user()->phone == null) ? '5529519407' : Auth::user()->phone,
            'custom_fields' => [
                'email'        => Auth::user()->email
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

            if ($order_x_product->price_x_unid < 1) {
                return back()->with('warning', 'Es necesario indicar un precio x pieza de cada producto');
            }

            $url = $order_x_product->product->preview;
            if (str_contains($url, ' ')) {
                $url = str_replace(" ",'%20', $url);
            }
            $preview = public_path('imgs/v3/logos/logo_alpha.png');
            if ($order_x_product->product->proveedor == 'DobleVela') {
                if($order_x_product->product->images != null)
                {
                    $img = json_decode($order_x_product->product->images)[0];
                    $preview = public_path('storage').'/doblevela/images/'.$img;
                }
            } else {
                $contents = file_get_contents($url);
                $name = substr($url, strrpos($url, '/') + 1);
                if (Storage::disk('cotizacion')->put($name, $contents)) {
                    $preview = public_path('storage').'/cotizaciones_imgs/'.$name;
                }
            }


            array_push($items, (new InvoiceItem())
                ->title($order_x_product->name)
                ->description($order_x_product->product->details)
                ->pricePerUnit($order_x_product->price_x_unid)
                ->quantity($order->total_products)
                ->tax(0)
                ->discount(0)
                ->img($preview)
            );
        }

        $notes = [
            'Forma de pago: '. $invoice->payment_days.' día(s)',
            'Tiempo de Entrega: '.$invoice->deliver_days.' días hábiles',
            'LOGOTIPOS CONVERTIDOS EN CURVAS, TIPOGRAFÍA, PANTONES A TRABAJAR',
        ];

        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('Cotización - '. $order->identifier)
            ->series($invoice->folio)
            // ability to include translated invoice status
            // in case it was paid
            ->status('PENDIENTE')
            ->sequence(0)
            ->serialNumberFormat('{SERIES}')
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
            ->vatTax('Precios más 16% de I.V.A. incluye flete '. $invoice->place)
            ->notes($notes)
            ->logo(public_path('imgs/v3/logos/logo_alpha.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();

        // Then send email to party with link
        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }

    public function addProduct( Request $request)
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
