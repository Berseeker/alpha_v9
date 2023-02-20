<?php

namespace App\Http\Controllers\API\Cotizaciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Venta;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Order::where('deleted_at',null)->get()->toJson();
        
        return $cotizaciones;
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email',
            'codigo_area' => 'required',
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
            'codigo_area.required' => 'Es necesario saber el codigo de area del telefono',
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
        $cotizacion->codigo_area = $request->codigo_area;
        $cotizacion->celular = $request->celular;
        $cotizacion->logo_img = null;
        $cotizacion->img_name = null;
        $cotizacion->comentarios = $request->comentarios;
        $cotizacion->medidas_deseables = json_encode($request->medidas_deseables);
        /*$dates = array();
        for($i=0;$i < $request->total_productos; $i++)
        {
            $time = strtotime($request->fecha_deseable[$i]);
            $date = date("Y-m-d",$time);
            array_push($dates,$date);
        }*/
        $cotizacion->fecha_deseable = json_encode($request->fecha_deseable);
        $cotizacion->pantones = json_encode($request->pantones);
        $cotizacion->tipografia = json_encode($request->tipografia);
        $precios_pza = array();
        for ($i=0; $i < $request->total_productos ; $i++) { 
            array_push($precios_pza,0);
        }
        $cotizacion->precio_pza = json_encode($precios_pza);
        $cotizacion->precio_x_producto = json_encode($precios_pza);
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
        $cotizacion->save();

        return response()->json([
            'status' => 'success',
            'msg' => 'La cotizacion se genero de manera exitosa'
        ]);

        
    }

    public function update(Request $request,$id)
    {
        $cotizacion = Cotizacion::find($id);
        if($cotizacion != null)
        {
            $cotizacion->status = $request->status;
            $cotizacion->user_id = $request->user_id;
            $cotizacion->save();
        }

        return response()->json([
            'msg' => 'La cotizacion se actualizo correctamente'
        ]);
    }

    public function delete($id)
    {
        $cotizacion = Cotizacion::find($id);
        if($cotizacion != null)
        {
            $venta = Venta::where('cotizacion_id',$cotizacion->id)->first();
            if($venta != null)
            {
                $venta->delete();
                $cotizacion->delete();
            }
            else {
                $cotizacion->delete();
            }
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Se elimino la cotizacion de manera correcta'
        ]);
    }
}
