<?php

namespace App\Http\Controllers\API\Proveedores;

use App\Jobs\Proveedores\InsertForPromotional;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class forPromotionalController extends Controller
{
    public function v2() {

        InsertForPromotional::dispatch();

        return response()->json([
            'status' => 'OK',
            'msg' => 'Se esta procesando el job'
        ]);
    }
}
