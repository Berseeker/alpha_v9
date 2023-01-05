<?php

namespace App\Http\Controllers\API\Proveedores;

use App\Jobs\Proveedores\InsertPromoOpcion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PromoOpcionController extends Controller
{
    public function v2()
    {
        InsertPromoOpcion::dispatch();

        return response()->json([
            'status' => 'OK',
            'msg' => 'Se esta procesando la tarea de PromoOpcion'
        ]);
    }
}