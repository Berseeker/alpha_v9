<?php

namespace App\Jobs\Proveedores;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertPromoOpcion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::withHeaders([
            'user' => 'GDL8043',
            'x-api-key' => 'e41f3d9771f94aa9c5e6edcc95d8e504'
        ])->post('https://www.contenidopromo.com/wsds/mx/catalogo/');

        $result = $response->json();

        if(array_key_exists('error',$result))
        {
            $log = new Logs();
            $log->status = 'Error';
            $log->message = $result['error'] . 'en PromoOpcion.';
            $log->save();
            Log::error($result['error'] . 'en PromoOpcion.');
        }

        $cont_new_products = 0; #Contador global
        $cont_update_products = 0; #Contador global
        foreach ($result as $key => $item) 
        {
            $prevItem = Product::where('code',$item['parent_code'])->where('proveedor','PromoOpcion')->first();
            if($prevItem == null)
            {
                $this->insertProduct($item, $cont_new_products); 
            } else {
                $this->updateProduct($item, $cont_update_products);
            }
              
        }

        $msg = '';
        if ($cont_new_products > 0) {
            $msg = $msg.$cont_new_products. ' productos nuevos';
        }
        if ($cont_update_products > 0) {
            $msg = $msg. ' y se actualizaron '. $cont_update_products. 'productos';
        }

        $log = new Logs();
        $log->status = 'Error';
        $log->message = $msg . 'en PromoOpcion.';
        $log->save();
        Log::error($msg . 'en PromoOpcion.');
    }

    private function insertProduct($item, &$cont_new_products) {
        $product = new Product();
    }

    private function updateProduct($item, &$cont_update_products) {

    }
}
