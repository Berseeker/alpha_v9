<?php

namespace App\Http\Controllers\WEB\Home;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Events\OrderCreated;
use App\Models\InvoiceOrder;
use App\Models\OrderProduct;
use App\Models\Shippment;
use App\Models\Categoria;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Order;

class CotizacionController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();

        $productos = array();

        if(Cookie::get('carrito_cotizaciones') != null)
        {
            $items = json_decode(Cookie::get('carrito_cotizaciones'));
            
            if (count($items) > 0) {

                foreach ($items as $item) 
                {
                    $producto = Product::where('code',$item)->first();
                    $img ='imgs/no_disp.png';
                    $imgs = json_decode($producto->images)[0];
                    if(!Str::contains($imgs,['https','http']))
                    {
                        $img = Storage::disk('doblevela_img')->url($imgs);
                    } else {
                        $img = $imgs;
                    }
        
                    $producto->imagen = $img;
                    array_push($productos,$producto);
                }
            }   
        }

        $total_productos = count($productos);
        
        return view('Home.cotizacion', [
            'categorias' => $categorias,
            'productos' => $productos,
            'total_productos' => $total_productos
        ]);

    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'deadline' => 'required',
            'fullNumber' => 'required',
            'country' => 'required',
            'city' => 'required',
            'producto_id' => 'required',
            'noPzas' => 'required',
            'cp' => 'required',
            'address' => 'required',
            'no_ink' => 'required'
        ];

        $messages = [
            'name.required' => 'Es necesario asignar un nombre',
            'lastname.required' => 'Es necesario asignar un apellido',
            'email.required' => 'Es necesario proporcionar un email para contactarnos',
            'deadline.required' => 'Es necesario indicar que dia quiere que se le entreguen los productos',
            'fullNumber.required' => 'Es necesario indicar un numero de contacto',
            'country.required' => 'Es necesario indicar el pais de procedencia',
            'city.required' => 'Es necesario indicar la ciudad a donde se enviarian los productos',
            'producto_id' => 'Es necesario indicar el id de los productos',
            'noPzas.required' => 'Es necesario indicar el numero de piezas a cotizar',
            'cp.required' => 'Es necesario indicar tu codigo postal',
            'address.required' => 'Es necesario indicar el nombre de tu calle',
            'no_ink.required' => 'Es necesario indicar el numero de tintas que requiere el producto'
        ];

        $this->validate($request,$rules,$messages);

        $total_productos = count($request->producto_id); 

        $uuid = (string) Str::uuid();
        $order = new Order();
        $order->order_id = $uuid;
        $order->name = $request->name;
        $order->lastname = $request->lastname;
        $order->email = $request->email;
        $order->code_area = substr($request->fullNumber, 0, 3);
        $order->phone = $request->phone;
        $order->isWhatsApp = ($request->isWhatsApp) ? 1 : 0;
        $order->country = $request->country;
        $order->state = $request->state;
        $order->address = $request->address;
        $order->cp = (int) $request->cp;
        $order->city = $request->city;
        $order->ext_num = $request->no_ext;
        $order->comments = ($request->filled('comments')) ? trim($request->comments) : null;
        $order->deadline = $request->deadline;
        $order->order_status = 'PENDANT';
        $total_count = 0;
        if (Order::count() > 0) {
            $total_count = Order::count();
        }
        $order->identifier = 'ALPH-' . ($total_count + 1);
        if($request->hasFile('files'))
        {
            // PUNTO A MEJORAR - COMPRIMIR ARCHIVOS
            $file = $request->file('files');
            $fileName = $uuid . '_' .$file->getClientOriginalName();  
            $path_logo = $file->storeAs(
                'orders_logo',
                $fileName,
                'public'
            );
 
            $order->file_path = $path_logo;

        }else{
            $order->file_path = null;
        }
        $order->user_id = 1; // Default User
        $order->total_products = count($request->producto_id);
        $order->save();

        foreach ($request->producto_id as $key => $id) {
            $product = Product::find($id);
            if ($product != null) {
                $order_x_product = new OrderProduct();
                $order_x_product->order_id = $uuid;
                $order_x_product->product_id = $product->id;
                $order_x_product->name = $product->name;
                $order_x_product->printing_area = ($product->printing_area == null) ? 'Sin especificar' : $product->printing_area;
                $order_x_product->pantone = $request->pantone[$key];
                $order_x_product->num_ink = (int) $request->no_ink[$key];
                $order_x_product->num_pzas = $request->noPzas[$key];
                $order_x_product->printing_method = $request->printing_methods[$key];
                $order_x_product->provider = $product->proveedor;
                $order_x_product->tax = 0.0;
                $order_x_product->save();
            } else {
                $order_x_product = new OrderProduct();
                $order_x_product->order_id = $uuid;
                $order_x_product->product_id = $id;
                $order_x_product->printing_area = 'Sin definir';
                $order_x_product->pantone = $request->pantone[$key];
                $order_x_product->num_ink = (int) $request->no_ink[$key];
                $order_x_product->num_pzas = $request->noPzas[$key];
                $order_x_product->printing_method = $request->printing_methods[$key];
                $order_x_product->provider = 'Alphapromos';
                $order_x_product->tax = 0.0;
                $order_x_product->save();
            }
        }

        $payment = new Payment();
        $payment->order_id = $uuid;
        $payment->payment_status = 'IN_PROCESS';
        $payment->payment_format = 'OTHER';
        $payment->entity = 'OTRO';
        $payment->save();

        $shippment = new Shippment();
        $shippment->order_id = $uuid;
        $shippment->warehouse = 'AJUSCO';
        $shippment->country = 'MÉXICO';
        $shippment->destination = $order->state .', ' . $order->city . ', CP: ' . $order->cp . ', ' . $order->address;
        $shippment->shippment_status = 'PENDANT';
        $shippment->accompanion = 'Sin asignar';
        $shippment->reciever = $order->name . ' ' . $order->lastname;
        $shippment->code_area = $order->code_area;
        $shippment->phone = $order->phone;
        $shippment->details = NULL;
        $shippment->user_id = 1;
        $shippment->save();

        $invoice = new InvoiceOrder();
        $invoice->order_id = $order->order_id;
        $invoice->payment_days = 1;
        $invoice->deliver_days = 1;
        $invoice->place = $order->state;
        $invoice->user_id = 1;
        $invoice->save();

        setcookie('carrito_cotizaciones', NULL);

        OrderCreated::dispatch($order);

        return back()->with('success','Hemos recibido tu solicitud, pronto nos pondremos en contacto con usted.');
    }
}
