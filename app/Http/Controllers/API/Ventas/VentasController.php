<?php

namespace App\Http\Controllers\API\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OrderProduct;
use App\Models\Sale;

class VentasController extends Controller
{
    public function index()
    {
        $ventas = Sale::where('deleted_at',null)->get();

        $sales = array();

        foreach ($ventas as $key => $venta) {
            $products = OrderProduct::where('order_id', $venta->order->order_id)->get();

            $total = 0;

            foreach ($products as $key => $product) {
                $total = $total + ($product->num_pzas * $product->price_x_unid);
            }
            $sale =  [
                'id' => $venta->order->identifier,
                'nombre' => $venta->order->name,
                'venta_realizada' => $venta->created_at,
                'total' => $total,
                'status' => $venta->order->order_status,
                'seller' => $venta->seller->name
            ];

            array_push($sales, $sale);
        }

        return json_encode($sales);
    }
}
