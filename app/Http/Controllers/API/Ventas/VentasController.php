<?php

namespace App\Http\Controllers\API\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venta;

class VentasController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('user')->where('deleted_at',null)->get()->toJson();
        
        return $ventas;
    }
}
