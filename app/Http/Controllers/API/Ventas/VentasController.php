<?php

namespace App\Http\Controllers\API\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OrderProduct;
use App\Models\User;
use App\Models\Order;
use App\Models\Sale;

class VentasController extends Controller
{
    public function index()
    {
        $ventas = Sale::where('deleted_at',null)->get();

        $sales = array();

        foreach ($ventas as $key => $venta) {

            $order = Order::find($venta->order_id);
            $products = OrderProduct::where('order_id', $order->order_id)->get();
            $seller = User::find($venta->user_id);

            $total = 0;

            foreach ($products as $key => $product) {
                $total = $total + ($product->num_pzas * $product->price_x_unid);
            }
            $sale =  [
                'id' => $order->identifier,
                'nombre' => $order->name,
                'venta_realizada' => $venta->created_at,
                'total' => $total,
                'status' => $order->order_status,
                'seller' => $seller->name,
                'order_id' => $order->order_id
            ];

            array_push($sales, $sale);
        }

        return json_encode($sales);
    }
}
