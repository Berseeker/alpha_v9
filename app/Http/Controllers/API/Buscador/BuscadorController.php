<?php

namespace App\Http\Controllers\API\Buscador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Producto;

class BuscadorController extends Controller
{
    public function search($search)
    {
        $productos = Producto::search($search)->get();
        return $productos->toJson();
    }
}
