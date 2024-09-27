<?php

namespace App\Http\Controllers\API\Proveedores;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Bus\Batch;
use App\Jobs\Proveedores\UpdateBatchImgDobleVela;
use App\Jobs\Proveedores\UpdateImgDobleVela;
use App\Jobs\Proveedores\InsertDobleVela;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Items;



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

        $productos = Product::where('proveedor', 'DobleVela')->where('images', NULL)->orderBy('id', 'asc')->count();
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

    public function updateImgExcel(Request $request) {
        $rules = [
            'archivo_urls' => 'required|file'
        ];

        $messages = [
            'archivo_urls.required' => 'Es necesario este campo',
            'archivo_urls.file' => 'Es necesario un archivo'
        ];

        $this->validate($request, $rules, $messages);

        $file = $request->file('archivo_urls');
        $path = Storage::put('URLS/doblevela', $file);
        $storage_path = storage_path('app');
        $file = $storage_path . '/' . $path;

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getSheet(0);
        $dataArray = $worksheet->toArray();
        
        foreach ($dataArray as $row) {
            // Here we are looking for any images that start with https
            if ($row[4] != null && str_contains($row[4], 'https')) {
                $product = Product::where('code', $row[2])->first();
                if ($product != null) {
                    $images = json_decode($product->images);
                    if (empty($images) || gettype($images) == 'string') {
                        $product->images = json_encode([$row[4]]);
                        $product->save();
                    }
                }
            }
        }

        //We need to ensure that the file is getting erased

        return response()->json([
            'status' => 'OK',
            'msg' => 'Se esta procesando las imagenes para DobleVela'
        ]);
    }

    public function empty() {

        $productos = Product::where('proveedor','DobleVela')->where('images',null)->get();
            dd(count($productos), $productos[0]);
    }

    public function test() {
        $product = Product::where('images', NULL)->where('proveedor', 'DobleVela')->first();
        dd($product);
    }
}
