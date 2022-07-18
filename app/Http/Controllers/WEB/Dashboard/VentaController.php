<?php

namespace App\Http\Controllers\WEB\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venta;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();

        $breadcrumbs = [
            ['link' => "/home", 'name' => "Dashboard"], ['name' => "Ventas"]
        ];

        return view('dashboard.ventas.index',[
            'ventas' => $ventas,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
