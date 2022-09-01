<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Categoria;
use App\Models\Cotizacion;
use App\Models\Venta;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cotizaciones = DB::table('cotizaciones')->count();
        $productos = DB::table('productos')->count();
        $ventas = Venta::sum('total');
        //dd(Auth::user()->getAllPermissions());
    
        return view('home',[
            'cotizaciones' => $cotizaciones,
            'productos' => $productos,
            'ventas' => $ventas
        ]);
    }
}
