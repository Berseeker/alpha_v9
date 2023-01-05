<?php

namespace App\Http\Controllers\API\Proveedores;

use App\Jobs\Proveedores\InsertInnova;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class InnovationController extends Controller
{
    public function v2() {

        InsertInnova::dispatch();

        return response()->json([
            'status' => 'OK',
            'msg' => 'Se esta procesando el job'
        ]);
    }
}