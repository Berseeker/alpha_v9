<?php

namespace App\Http\Controllers\API\Proveedores;

use App\Jobs\Proveedores\UpdateBatchImgDobleVela;
use App\Jobs\Proveedores\UpdateImgDobleVela;
use App\Jobs\Proveedores\InsertDobleVela;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Bus\Batch;
use App\Models\Product;



class DobleVelaController extends Controller
{

    public function __construct()
    {
        //
    }

    public function v2()
    {
        InsertDobleVela::dispatch();

        return response()->json([
            'status' => 'OK',
            'msg' => 'Se esta procesando la tarea'
        ]);
    }

    public function imgsV2() {

        $productos = Producto::where('proveedor', 'DobleVela')->orderBy('id', 'asc')->count();
        if ($productos % 4 == 0) {

            $limit = $productos / 4;
            $limit_2 = $limit + $limit;
            $limit_3 = $limit_2 * $limit;
            $limit_4 = $limit_3 * $limit;

            $batch = Bus::batch([
                new UpdateBatchImgDobleVela(0, $limit),
                new UpdateBatchImgDobleVela($limit, $limit_2),
                new UpdateBatchImgDobleVela($limit_2, $limit_3),
                new UpdateBatchImgDobleVela($limit_3, $limit_4),
            ])->then(function (Batch $batch) {
                // All jobs completed successfully...
            })->catch(function (Batch $batch, Throwable $e) {
                Log::error(print_r($e));
            })->finally(function (Batch $batch) {
                // The batch has finished executing...
            })->dispatch();
        } else {
            UpdateImgDobleVela::dispatch();
        }


        return response()->json([
            'status' => 'OK',
            'msg' => 'Se esta procesando las imagenes para DobleVela'
        ]);
    }

    public function updateImgV2() {
        UpdateImgDobleVela::dispatch();
        return response()->json([
            'status' => 'OK',
            'msg' => 'Se esta procesando las imagenes para DobleVela'
        ]);
    }

    public function empty() {

        $productos = Producto::where('proveedor','DobleVela')->where('images',null)->get();
        dd(count($productos), $productos[0]);
    }
}
