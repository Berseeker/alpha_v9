<?php

namespace App\Jobs\Proveedores;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Models\Product;
use App\Models\Logs;

use SoapClient;

class UpdateBatchImgDobleVela implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 6000;

    protected $limit;
    protected $offset;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        if ($this->batch()->cancelled()) {

            Log::error('Error en el batch ');
 
            return;
        }

        $productos = Product::where('proveedor','DobleVela')->orderBy('id', 'asc')->offset($this->offset)->limit($this->limit)->get();
        foreach ($productos as $producto) 
        {
            /* PROCESO DE OBTENCION DE IMAGENES */
            $response = Http::asForm()->post('srv-datos.dyndns.info/doblevela/service.asmx/GetrProdImagenes', [
                'Codigo' => '{"CLAVES": ["'.$producto->parent_code.'"]}',
                'Key' => 'jk3CttIRpY+iQT8m/i0uzQ==',
            ]);
            $result = $response->body();
            $xml = simplexml_load_string($result);
            $array = $this->xml2array($xml);
            $result2 = json_decode($array[0], true);
   
            $cont = 0;
            $num = 0;
            $imgs = array();
            if ( !empty($result2['Resultado']['MODELOS']) ) {

                foreach($result2['Resultado']['MODELOS'] as $item)
                {
                    foreach($item['encodedImage'] as $img_base64)
                    {
                        $image = str_replace('data:image/png;base64,', '', $img_base64);
                        $image = str_replace(' ', '+', $image);
                        $imageName = $producto->parent_code.$num.'.png';

                        if (!Storage::disk('doblevela_img')->exists($imageName)) 
                        {
                            Storage::disk('doblevela_img')->put($imageName, base64_decode($image));
                            array_push($imgs,$imageName);
                            $num++;
                        }
                    }
                    $cont++;
                }
            }

            if(empty($imgs)){
                $imgs = null;
            }else{
                $imgs = json_encode($imgs);
            }
            
            /* FIN DE PROCESO DE OBTENCION DE IMAGENES */
            $producto->images = $imgs;
            $producto->save();
        }
        
        $log = new Logs();
        $log->status = 'success';
        $log->message = 'Se actualizaron '.$cont.' productos con imagenes de DobleVela';
        $log->save();

        Log::info('Se actualizaron '.$cont.' productos con imagenes de DobleVela');
    }

    private function xml2array ( $xmlObject, $out = array () )
    {
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

        return $out;
    }
}
