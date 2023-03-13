<?php

namespace App\Jobs\Proveedores;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Events\ProviderUpdated;
use App\Models\Product;
use App\Models\Logs;

class InsertInnova implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $client;
    protected $endpoint = 'https://ws.innovation.com.mx/index.php?wsdl';
    protected $error;

    public function __construct()
    {
        $this->client = new \nusoap_client($this->endpoint, 'wsdl');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->error = $this->client->getError();
        if ($this->error) 
        {
            if (isset($this->error['code']) && $this->error['code'] == '#10004') {
                $log = new Logs();
                $log->status = 'Error';
                $log->message = $this->error['message'] . 'en Innova.';
                $log->save();

                Log::error($this->error['message'] . 'en Innova.');
            };
            exit();
        }

        $params = [
            'user_api' => 'Pu7P5Qy602ea9d959f19Byo7',
            'api_key' => '76o602ea9d959f1f4awL8R-AzIa',
            'format' => 'JSON'
        ];

        $response = $this->client->call('Pages', $params);
        $response = json_decode($response, true);
        if (isset($response['code']) && $response['code'] == '#10004') {
            $log = new Logs();
            $log->status = 'Error';
            $log->message = $this->error['message'] . 'en Innova.';
            $log->save();

            Log::error($this->error['message'] . 'en Innova.');
            exit();
        }
        //Result send by the endpoint: {"response":true,"code":"SUCCESS","pages":9}
        $api_ids = array();
        
        for ($i = 1; $i <= (int) $response['pages']; $i++ ) 
        {
            $params = [
                'user_api' => 'Pu7P5Qy602ea9d959f19Byo7',
                'api_key' => '76o602ea9d959f1f4awL8R',
                'format' => 'JSON',
                'page' => $i
            ];
            //Método para obtener información  de Productos
            $response = $this->client->call('Products', $params);
            $response = json_decode($response, true);
            if(isset($response['response']) && $response['response'] == true) {
                foreach ($response['data'] as $key => $value) 
                {
                    array_push($api_ids, $value['codigo']);
                    $product = Product::where('code',$value['codigo'])->where('proveedor','Innova')->first();
                    if ($product != null) {
                        $this->insertProduct($value);
                    } else {
                        $this->updateProduct($value);
                    }
                    
                }
            } else {
                $log = new Logs();
                $log->status = 'Error';
                $log->message = $response['message'] . 'en Innova.';
                $log->save();
                Log::error($response['message'] . 'en Innova.');
            }
        }

        Product::where('proveedor','Innova')->whereNotIn('parent_code', $api_ids)->delete();
        ProviderUpdated::dispatch('Innova');
    }

    private function insertProduct($producto)
    {
        dd($producto);
        $item = new Product();
        $item->name = $producto['nombre'];
        $item->code = $producto['codigo'];
        $item->parent_code = $producto['codigo'];
        $item->discount = 0.0;
        /* Manipulacion de Colores e Imagenes */
        $images = array();
        $colores = array();
        array_push($images, $producto['imagen_principal']);
        
        foreach ($producto['colores'] as $color) {
            array_push($colores, $color['codigo_color']);
            array_push($images, $color['image']);
        }
        foreach ($producto['images'] as $image) {
            array_push($images, $image['image']);
        }
        foreach ($producto['imagenes_adicionales'] as $image) {
            array_push($images, $image);
        }

        $item->colors = json_encode($colores);
        $item->details = $producto['descripcion'];
        $item->stock = 0;
        $item->price = 0;
        $item->nw = $producto['peso_paquete'];
        $item->gw = 'Sin definir';
        $item->weight_product = $producto['peso_producto'];
        $item->medida_producto_alto = $producto['medidas_producto'];
        $item->printing_area = $producto['area_impresion'];
        $printing_methods = array();
        foreach ($product['tecnicas_impresion'] as $printing) {
            array_push($printing_methods, $printing['codigo']);
        }
        $item->printing_methods = json_encode($printing_methods);
        $item->category = $producto['categorias']['categorias'][0]['nombre'];
        $item->subcategory = $producto['subcategorias']['subcategorias'][0]['nombre'];
        $item->box_pieces = $producto['cantidad_por_paquete'];
        $item->images = $images;
        $item->material = Str::ucfirst($producto['material']);
        $item->proveedor = 'Innova';
        $item->custom = false;
        
        if($producto['categorias']['categorias'][0]['nombre'] == 'Cuidado Personal')
        {
            if(Str::contains($producto['nombre'], 'antibacterial'))
            {
                $item->categoria_id = 3;
                $item->subcategoria_id = 94;
                $item->search = 'SALUD Y CUIDADO PERSONAL, ARTICULOS DE CONTINGENCIA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $producto['meta_keywords'] . ', SALUD Y CUIDADO PERSONAL, ARTICULOS DE CONTINGENCIA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);

            }
            else if(Str::contains($producto['nombre'], 'esterilizadora'))
            {
                $item->categoria_id = 3;
                $item->subcategoria_id = 94;
                $item->search = 'SALUD Y CUIDADO PERSONAL, ARTICULOS DE CONTINGENCIA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $producto['meta_keywords'] . ', SALUD Y CUIDADO PERSONAL, ARTICULOS DE CONTINGENCIA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);

            }
            else {
                $item->categoria_id = 3;
                $item->subcategoria_id = 19;
                $item->search = 'SALUD Y CUIDADO PERSONAL, CUIDADO PERSONAL, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $producto['meta_keywords'] . ', SALUD Y CUIDADO PERSONAL, CUIDADO PERSONAL, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            }
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Belleza')
        {
            $item->subcategoria_id = 17;
            $item->categoria_id = 3;
            $item->search = 'SALUD Y CUIDADO PERSONAL, BELLEZA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $producto['meta_keywords'] . ', SALUD Y CUIDADO PERSONAL, BELLEZA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Escritura')
        {
            if(count($producto['categorias']['subcategorias']) > 0)
            {
                if($producto['categorias']['subcategorias'][0]['codigo'] == 'boligrafos')
                {
                    if($producto['material'] == 'METAL' || $producto['material'] == 'ALUMINIO')
                    {
                        $item->subcategoria_id = 7;
                        $item->categoria_id = 2;
                        $item->search = 'BOLIGRAFOS, BOLIGRAFOS METALICOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']); 
                        $item->meta_keywords = $producto['meta_keywords'] . ', BOLIGRAFOS, BOLIGRAFOS METALICOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']); 
                    }
                    else if($producto['material'] == 'CARTON' || $producto['material'] == 'BAMBOO' || $producto['material'] == 'CORCHO' || $producto['material'] == 'FIBRA DE TRIGO')
                    {
                        $item_2 = new Product();
                        $item_2->name = $producto['nombre'];
                        $item_2->code = $producto['codigo'];
                        $item_2->parent_code = $producto['codigo'];
                        $item_2->discount = 0.0;
                        $item_2->colors = json_encode($colores);
                        $item_2->details = $producto['descripcion'];
                        $item_2->stock = 0;
                        $item_2->price = 0;
                        $item_2->nw = $producto['peso_paquete'];
                        $item_2->gw = 'Sin definir';
                        $item_2->weight_product = $producto['peso_producto'];
                        $item_2->medida_producto_alto = $producto['medidas_producto'];
                        $item_2->printing_area = $producto['area_impresion'];
                        $item_2->printing_methods = json_encode($printing_methods);
                        $item_2->category = $producto['categorias']['categorias'][0]['nombre'];
                        $item_2->subcategory = $producto['subcategorias']['subcategorias'][0]['nombre'];
                        $item_2->box_pieces = $producto['cantidad_por_paquete'];
                        $item_2->images = $images;
                        $item_2->material = Str::ucfirst($producto['material']);
                        $item_2->proveedor = 'Innova';
                        $item_2->custom = false;
                        $item_2->subcategoria_id = 37;
                        $item_2->categoria_id = 8;
                        $item_2->search = 'ECOLOGICOS, BOLIGRAFOS ECOLOGICOS, BOLIGRAFOS, BOLÍGRAFOS, ECOLOGÍA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item_2->meta_keywords = $producto['meta_keywords'] . ', ECOLOGICOS, BOLIGRAFOS ECOLOGICOS, BOLIGRAFOS, BOLÍGRAFOS, ECOLOGÍA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item_2->save();

                        $item->subcategoria_id = 10;
                        $item->categoria_id = 2;
                        $item->search = 'ECOLOGICOS, BOLIGRAFOS ECOLOGICOS, BOLIGRAFOS, BOLÍGRAFOS, ECOLOGÍA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                    else if($producto['material'] == 'PLÁSTICO')
                    {
                        $item->subcategoria_id = 9;
                        $item->categoria_id = 2;
                        $item->search = 'BOLIGRAFOS, BOLIGRAFOS DE PLASTICO, BOLÍGRAFOS DE PLÁSTICO, PLÁSTICO, BOLÍGRAFO PLASTICO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']); 
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                    else 
                    {
                        $item->subcategoria_id = 15;
                        $item->categoria_id = 2;
                        $item->search = 'BOLIGRAFOS,OTROS BOLIGRAFOS, BOLÍGRAFOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                }
                else if($producto['categorias']['subcategorias'][0]['codigo'] == 'marca-textos')
                {
                    $item->subcategoria_id = 55;
                    $item->categoria_id = 10;
                    $item->search = 'OFICINA, MARCA TEXTOS, PLUMON, PLUMÓN, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
            }
            else{
                if($producto['material'] == 'METAL' || $producto['material'] == 'ALUMINIO')
                {
                    $item->subcategoria_id = 7;
                    $item->categoria_id = 2;
                    $item->search = 'BOLIGRAFOS, BOLIGRAFOS METALICOS, BOLÍGRAFOS, METAL, ALUMINIO, METÁL, ALUMÍNIO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else if($producto['material'] == 'CARTON' || $producto['material'] == 'BAMBOO' || $producto['material'] == 'CORCHO' || $producto['material'] == 'FIBRA DE TRIGO')
                {
                    $item_2 = new Product();
                    $item_2->name = $producto['nombre'];
                    $item_2->code = $producto['codigo'];
                    $item_2->parent_code = $producto['codigo'];
                    $item_2->discount = 0.0;
                    $item_2->colors = json_encode($colores);
                    $item_2->details = $producto['descripcion'];
                    $item_2->stock = 0;
                    $item_2->price = 0;
                    $item_2->nw = $producto['peso_paquete'];
                    $item_2->gw = 'Sin definir';
                    $item_2->weight_product = $producto['peso_producto'];
                    $item_2->medida_producto_alto = $producto['medidas_producto'];
                    $item_2->printing_area = $producto['area_impresion'];
                    $item_2->printing_methods = json_encode($printing_methods);
                    $item_2->category = $producto['categorias']['categorias'][0]['nombre'];
                    $item_2->subcategory = $producto['subcategorias']['subcategorias'][0]['nombre'];
                    $item_2->box_pieces = $producto['cantidad_por_paquete'];
                    $item_2->images = $images;
                    $item_2->material = Str::ucfirst($producto['material']);
                    $item_2->proveedor = 'Innova';
                    $item_2->custom = false;
                    $item_2->subcategoria_id = 37;
                    $item_2->categoria_id = 8;
                    $item_2->search = 'ECOLOGICOS,BOLIGRAFOS ECOLOGICOS, ESCRITURA, ECOLOGÍA, ECOLÓGICO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item_2->meta_keywords = $item_2->search . ', ' .$producto['meta_keywords'];
                    $item_2->save();

                    $item->subcategoria_id = 10;
                    $item->categoria_id = 2;
                    $item->search = 'ECOLOGICOS,BOLIGRAFOS ECOLOGICOS, ESCRITURA, ECOLOGÍA, ECOLÓGICO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else if($producto['material'] == 'PLÁSTICO')
                {
                    $item->subcategoria_id = 9;
                    $item->categoria_id = 2;
                    $item->search = 'BOLIGRAFOS, BOLÍGRAFOS, ESCRITURA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']); 
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else {
                    $item->subcategoria_id = 15;
                    $item->categoria_id = 2;
                    $item->search = 'BOLIGRAFOS, BOLÍGRAFOS, ESCRITURA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
            }
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Oficina')
        {
            if(Str::contains($producto['nombre'], 'Libreta ecológica'))
            {
                $item_2 = new Product();
                $item_2->name = $producto['nombre'];
                $item_2->code = $producto['codigo'];
                $item_2->parent_code = $producto['codigo'];
                $item_2->discount = 0.0;
                $item_2->colors = json_encode($colores);
                $item_2->details = $producto['descripcion'];
                $item_2->stock = 0;
                $item_2->price = 0;
                $item_2->nw = $producto['peso_paquete'];
                $item_2->gw = 'Sin definir';
                $item_2->weight_product = $producto['peso_producto'];
                $item_2->medida_producto_alto = $producto['medidas_producto'];
                $item_2->printing_area = $producto['area_impresion'];
                $item_2->printing_methods = json_encode($printing_methods);
                $item_2->category = $producto['categorias']['categorias'][0]['nombre'];
                $item_2->subcategory = $producto['subcategorias']['subcategorias'][0]['nombre'];
                $item_2->box_pieces = $producto['cantidad_por_paquete'];
                $item_2->images = $images;
                $item_2->material = Str::ucfirst($producto['material']);
                $item_2->proveedor = 'Innova';
                $item_2->custom = false;
                $item_2->subcategoria_id = 38;
                $item_2->categoria_id = 8;
                $item_2->search = 'ECOLOGICOS, LIBRETAS ECOLOGICAS, LIBRETAS, LIBRETAS ECOLÓGICAS, ECOLOGÍA, ECOLÓGICO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item_2->meta_keywords = $item_2->search . ', ' .$producto['meta_keywords'];
                $item_2->save();

                $item->subcategoria_id = 48;
                $item->categoria_id = 10;
                $item->search = 'ECOLOGICOS, LIBRETAS ECOLOGICAS, LIBRETAS, LIBRETAS ECOLÓGICAS, ECOLOGÍA, ECOLÓGICO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];

            }
            else if(Str::contains($producto['nombre'], 'Porta gafete'))
            {
                $item->subcategoria_id = 53;
                $item->categoria_id = 10;
                $item->search = 'OFICINA, LIBRETAS, CUADERNOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else if(Str::contains($producto['nombre'], 'Cubo ecológico'))
            {
                $item_2 = new Product();
                $item_2->name = $producto['nombre'];
                $item_2->code = $producto['codigo'];
                $item_2->parent_code = $producto['codigo'];
                $item_2->discount = 0.0;
                $item_2->colors = json_encode($colores);
                $item_2->details = $producto['descripcion'];
                $item_2->stock = 0;
                $item_2->price = 0;
                $item_2->nw = $producto['peso_paquete'];
                $item_2->gw = 'Sin definir';
                $item_2->weight_product = $producto['peso_producto'];
                $item_2->medida_producto_alto = $producto['medidas_producto'];
                $item_2->printing_area = $producto['area_impresion'];
                $item_2->printing_methods = json_encode($printing_methods);
                $item_2->category = $producto['categorias']['categorias'][0]['nombre'];
                $item_2->subcategory = $producto['subcategorias']['subcategorias'][0]['nombre'];
                $item_2->box_pieces = $producto['cantidad_por_paquete'];
                $item_2->images = $images;
                $item_2->material = Str::ucfirst($producto['material']);
                $item_2->proveedor = 'Innova';
                $item_2->custom = false;
                $item_2->subcategoria_id = 41;
                $item_2->categoria_id = 8;
                $item_2->search = 'ECOLOGICOS,OTROS ECOLOGICOS, CUBO, CÚBO, ECOLÓGICO, ECOLOGÍA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item_2->meta_keywords = $item_2->search . ', ' .$producto['meta_keywords'];
                $item_2->save();

                $item->subcategoria_id = 47;
                $item->categoria_id = 10;
                $item->search = 'OFICINA, LIBRETAS, ECOLOGÍA, ECOLÓGICO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else 
            {
                $item->subcategoria_id = 47;
                $item->categoria_id = 10;
                $item->search = 'OFICINA, ARTICULOS DE OFICINA, OFICÍNA, TRABAJO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Libretas')
        {
            $item->subcategoria_id = 48;
            $item->categoria_id = 10;
            $item->search = 'OFICINA, LIBRETAS, CUADERNO, OFICÍNA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Ejecutiva')
        {
            if(Str::contains($producto['nombre'], 'Carpeta'))
            {
                $item->subcategoria_id = 49;
                $item->categoria_id = 10;
                $item->search = 'OFICINA, CARPETA, EJECUTÍVO, EJECUTÍVA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else if(Str::contains($producto['nombre'], 'Maletín'))
            {
                $item->subcategoria_id = 29;
                $item->categoria_id = 5;
                $item->search = 'TEXTIL, TEXTÍL, MALETINES, MALETIN, MALETÍN, MALETA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else if(Str::contains($producto['nombre'], 'Mochila'))
            {
                $item->subcategoria_id = 24;
                $item->categoria_id = 5;
                $item->search = 'TEXTIL, TEXTÍL, MOCHILAS, MOCHÍLA, MOCHILA, BACKPACK, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else if(Str::contains($producto['nombre'], 'Portafolio') || Str::contains($producto['nombre'], 'Maleta'))
            {
                $item->subcategoria_id = 28;
                $item->categoria_id = 5;
                $item->search = 'TEXTIL, TEXTÍL, PORTAFOLIOS, PORTAFÓLIO, PORTAFOLIO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else if(Str::contains($producto['nombre'], 'Libreta'))
            {
                $item->subcategoria_id = 48;
                $item->categoria_id = 10;
                $item->search = 'OFICINA, LIBRETAS, CUADERNO, TRABAJO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else 
            {
                $item->subcategoria_id = 47;
                $item->categoria_id = 10;
                $item->search = 'EJECUTIVA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Viaje')
        {
            $item->subcategoria_id = 20;
            $item->categoria_id = 4;
            $item->search = 'VIAJE, ACCESORIOS DE VIAJE, AVIÓN, VACACIONES, OCIO, VACACÍONES, ÓCIO, RECREACIÓN, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Herramientas')
        {
            if(Str::contains($producto['nombre'], 'Navaja'))
            {
                $item->subcategoria_id = 35;
                $item->categoria_id = 7;
                $item->search = 'HERRAMIENTAS, NAVAJAS MULTIFUNCIONALES, CUCHILLO, NAVÁJA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else if(Str::contains($producto['nombre'], 'Llavero'))
            {
                if($producto['material'] == 'ACERO')
                {
                    $item->subcategoria_id = 80;
                    $item->categoria_id = 15;
                    $item->search = 'LLAVEROS, LLAVEROS METALICOS, METAL, METÁL, LLAVÉRO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else if($producto['material'] == 'PLÁSTICO')
                {
                    $item->subcategoria_id = 81;
                    $item->categoria_id = 15;
                    $item->search = 'LLAVEROS, LLAVEROS PLASTICO, PLÁSTICO, LLAVÉRO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else {
                    $item->subcategoria_id = 84;
                    $item->categoria_id = 15;
                    $item->search = 'LLAVEROS,OTROS LLAVEROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
            }
            else if(Str::contains($producto['nombre'], 'Lámpara'))
            {
                $item->subcategoria_id = 34;
                $item->categoria_id = 7;
                $item->search = 'HERRAMIENTAS, LAMPARAS, LÁMPARA, LUZ, LINTERNA, LINTÉRNA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else {
                $item->subcategoria_id = 33;
                $item->categoria_id = 7;
                $item->search = 'HERRAMIENTAS, TRABAJO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Bar')
        {
            if(Str::contains($producto['nombre'], 'Hielera'))
            {
                $item->subcategoria_id = 26;
                $item->categoria_id = 5;
                $item->search = 'TEXTIL, TEXTÍL, LONCHES Y HIELERAS, HIELERA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            if(Str::contains($producto['nombre'], 'Llavero'))
            {
                if($producto['material'] == 'METAL')
                {
                    $item->subcategoria_id = 80;
                    $item->categoria_id = 15;
                    $item->search = 'LLAVEROS, LLAVEROS METALICOS, METAL, METÁL, LLAVÉRO, LLAVERO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else {
                    $item->subcategoria_id = 84;
                    $item->categoria_id = 15;
                    $item->search = 'LLAVEROS, OTROS LLAVEROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
            }
            else {
                $item->subcategoria_id = 43;
                $item->categoria_id = 9;
                $item->search = 'HOGAR, BAR, BEBIDAS, COCTEL, COCTÉL, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Sets de Regalo')
        {
            if(Str::contains($producto['nombre'], 'BBQ'))
            {
                $item->subcategoria_id = 44;
                $item->categoria_id = 9;
                $item->search = 'HOGAR, BBQ, SET DE COCINA, REGALO, BARBACOA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else {
                $item->subcategoria_id = 93;
                $item->categoria_id = 20;
                $item->search = 'SET DE REGALO, REGALOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Escolares y Niños')
        {
            $item->subcategoria_id = 92;
            $item->categoria_id = 19;
            $item->search = 'KIDS Y ESCOLARES, ESCOLARES, ESCUELA, REGRESO A CLASES, TAREAS, NIÑOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Hogar')
        {
            if(Str::contains($producto['nombre'], 'BBQ'))
            {
                $item->subcategoria_id = 44;
                $item->categoria_id = 9;
                $item->search = 'HOGAR, BBQ, BARBACOA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }else {
                $item->subcategoria_id = 45;
                $item->categoria_id = 9;
                $item->search = 'HOGAR, OTROS HOGAR, CASA, JARDIN, JARDÍN, PATIO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Relojes')
        {
            if(count($producto['categorias']['subcategorias']) > 0)
            {
                if($producto['categorias']['subcategorias'][0]['codigo'] == 'estuches-de-reloj')
                {
                    $item->subcategoria_id = 86;
                    $item->categoria_id = 17;
                    $item->search = 'RELOJES, ESTUCHES, RELÓJ, RELOJ, WATCH, ESTÚCHE,' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']); 
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else if($producto['categorias']['subcategorias'][0]['codigo'] == 'pared-y-escritorio')
                {
                    $item->subcategoria_id = 87;
                    $item->categoria_id = 17;
                    $item->search = 'RELOJES,PARED Y ESCRITORIO, DESKTOP, MUEBLE, RELÓJ, RELOJ, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else if($producto['categorias']['subcategorias'][0]['codigo'] == 'relojes-de-pulso')
                {
                    $item->subcategoria_id = 88;
                    $item->categoria_id = 17;
                    $item->search = 'RELOJES, RELOJ DE PULSO, RELÓJ, RELOJ,' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
            }
            else
            {
                $item->subcategoria_id = 97;
                $item->categoria_id = 17;
                $item->search = 'RELOJES, OTROS RELOJES, RELÓJ, RELOJ, WATCH, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Llaveros')
        {
            if(Str::contains($producto['nombre'], 'LLavero'))
            {
                if($producto['material'] == 'ACERO' || $producto['material'] == 'ALEACION DE ZINC')
                {
                    $item->subcategoria_id = 80;
                    $item->categoria_id = 15;
                    $item->search = 'LLAVEROS,LLAVEROS METALICOS, METAL, METÁL, LLAVÉROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else if($producto['material'] == 'PLÁSTICO')
                {
                    $item->subcategoria_id = 81;
                    $item->categoria_id = 15;
                    $item->search = 'LLAVEROS, LLAVEROS PLASTICO, PLÁSTICO, LLAVÉROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else if($producto['material'] == 'BAMBOO')
                {
                    $item_2 = new Product();
                    $item_2->name = $producto['nombre'];
                    $item_2->code = $producto['codigo'];
                    $item_2->parent_code = $producto['codigo'];
                    $item_2->discount = 0.0;
                    $item_2->colors = json_encode($colores);
                    $item_2->details = $producto['descripcion'];
                    $item_2->stock = 0;
                    $item_2->price = 0;
                    $item_2->nw = $producto['peso_paquete'];
                    $item_2->gw = 'Sin definir';
                    $item_2->weight_product = $producto['peso_producto'];
                    $item_2->medida_producto_alto = $producto['medidas_producto'];
                    $item_2->printing_area = $producto['area_impresion'];
                    $item_2->printing_methods = json_encode($printing_methods);
                    $item_2->category = $producto['categorias']['categorias'][0]['nombre'];
                    $item_2->subcategory = $producto['subcategorias']['subcategorias'][0]['nombre'];
                    $item_2->box_pieces = $producto['cantidad_por_paquete'];
                    $item_2->images = $images;
                    $item_2->material = Str::ucfirst($producto['material']);
                    $item_2->proveedor = 'Innova';
                    $item_2->custom = false;
                    $item_2->subcategoria_id = 41;
                    $item_2->categoria_id = 8;
                    $item_2->search = 'LLAVEROS, LLAVÉROS, ECOLOGICOS, OTROS ECOLOGICOS, ECOLÓGICO, ECOLOGÍA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item_2->meta_keywords = $item_2->search . ', ' .$producto['meta_keywords'];
                    $item_2->save();

                    $item->subcategoria_id = 84;
                    $item->categoria_id = 15;
                    $item->search = 'LLAVEROS, OTROS LLAVEROS, LLAVÉROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else {
                    $item->subcategoria_id = 84;
                    $item->categoria_id = 15;
                    $item->search = 'LLAVEROS, LLAVÉROS, OTROS LLAVEROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
            }
            else {
                $item->subcategoria_id = 84;
                $item->categoria_id = 15;
                $item->search = 'LLAVEROS,OTROS LLAVEROS, LLAVÉROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Tecnología')
        {
            if(Str::contains($producto['descripcion'], 'Memoria USB'))
            {
                $item->subcategoria_id = 3;
                $item->categoria_id = 1;
                $item->search = 'TECNOLOGIA, TECNOLOGÍA, MEMORIA, MEMÓRIA, TARJETA , USB, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else if(Str::contains($producto['nombre'], 'Audífonos') || $producto['nombre']== 'Audífono')
            {
                $item->subcategoria_id = 1;
                $item->categoria_id = 1;
                $item->search = 'TECNOLOGIA, TECNOLOGÍA, HEADPHONES, AURICULAR, AUDIFONOS, AUDÍFONOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else if(Str::contains($producto['nombre'], 'Cargador'))
            {
                $item->subcategoria_id = 5;
                $item->categoria_id = 1;
                $item->search = 'TECNOLOGIA, TECNOLOGÍA, ACCESORIOS DE SMARTPHONE, CARGADOR, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
            else {
                $item->subcategoria_id = 6;
                $item->categoria_id = 1;
                $item->search = 'TECNOLOGIA, TECNOLOGÍA, OTROS TECNOLOGIA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
            }
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Antiestrés')
        {
            $item->subcategoria_id = 59;
            $item->categoria_id = 12;
            $item->search = 'ANTIESTRES, ANTIESTRÉS, RELAJAR, RELAJANTE, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Bebidas')
        {
            if(count($producto['categorias']['subcategorias']) > 0)
            {
                if($producto['categorias']['subcategorias'][0]['codigo'] == 'tazas')
                {
                    $item->subcategoria_id = 74;
                    $item->categoria_id = 14;
                    $item->search = 'BEBIDAS, TAZAS Y TARROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
                else if($producto['categorias']['subcategorias'][0]['codigo'] == 'termos')
                {
                    if($producto['material'] == 'PLÁSTICO')
                    {
                        $item->subcategoria_id = 76;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS, TERMOS PLASTICOS, TÉRMO, PLÁSTICO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                    else if($producto['material'] == 'METAL' || $producto['material'] == 'ACERO' || $producto['material'] == 'TRITAN')
                    {
                        $item->subcategoria_id = 77;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS, TERMOS METALICOS, TÉRMO, BEBÍDA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                    else {
                        $item->subcategoria_id = 95;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS, BEBÍDAS, TÉRMOS, TERMOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                }
                else if($producto['categorias']['subcategorias'][0]['codigo'] == 'cilindros')
                {
                    if($producto['material'] == 'POLICARBONATO')
                    {
                        $item->subcategoria_id = 71;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS, BEBÍDAS, CILÍNDROS, CILINDROS PLASTICOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                    else if($producto['material'] == 'TRITAN' || $producto['material'] == 'ACERO')
                    {
                        $item->subcategoria_id = 72;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS, BEBÍDAS, CILÍNDROS, CILINDROS METALICOS, CILINDROS DE ACERO, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                    else if($producto['material'] == 'VIDRIO')
                    {
                        $item->subcategoria_id = 73;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS, CILINDROS DE VIDRIO, CRISTAL, BEBÍDAS, CILÍNDROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                    else {
                        $item->subcategoria_id = 71;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS, CILINDROS, BEBÍDAS, CILÍNDROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                }
                else if($producto['categorias']['subcategorias'][0]['codigo'] == 'vasos')
                {
                    $item->subcategoria_id = 75;
                    $item->categoria_id = 14;
                    $item->search = 'BEBIDAS, VASOS, BEBÍDAS, VÁSOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
            }
            else
            {
                if(Str::contains($producto['nombre'], 'Cilindro'))
                {
                    if($producto['material'] == 'POLICARBONATO' || $producto['material'] == 'PLÁSTICO')
                    {
                        $item->subcategoria_id = 71;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS, CILINDROS PLASTICOS, BEBÍDAS, CILÍNDROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                    else if($producto['material'] == 'TRITAN')
                    {
                        $item->subcategoria_id = 72;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS,CILINDROS METALICOS, BEBÍDAS, CILÍNDROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                    else {
                        $item->subcategoria_id = 71;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS,CILINDROS, BEBÍDAS, CILÍNDROS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                }
                else if(Str::contains($producto['nombre'], 'Termo'))
                {
                    if($producto['material'] == 'BAMBOO' ||$producto['material'] == 'FIBRA DE TRIGO')
                    {
                        $item_2 = new Product();
                        $item_2->name = $producto['nombre'];
                        $item_2->code = $producto['codigo'];
                        $item_2->parent_code = $producto['codigo'];
                        $item_2->discount = 0.0;
                        $item_2->colors = json_encode($colores);
                        $item_2->details = $producto['descripcion'];
                        $item_2->stock = 0;
                        $item_2->price = 0;
                        $item_2->nw = $producto['peso_paquete'];
                        $item_2->gw = 'Sin definir';
                        $item_2->weight_product = $producto['peso_producto'];
                        $item_2->medida_producto_alto = $producto['medidas_producto'];
                        $item_2->printing_area = $producto['area_impresion'];
                        $item_2->printing_methods = json_encode($printing_methods);
                        $item_2->category = $producto['categorias']['categorias'][0]['nombre'];
                        $item_2->subcategory = $producto['subcategorias']['subcategorias'][0]['nombre'];
                        $item_2->box_pieces = $producto['cantidad_por_paquete'];
                        $item_2->images = $images;
                        $item_2->material = Str::ucfirst($producto['material']);
                        $item_2->proveedor = 'Innova';
                        $item_2->custom = false;
                        $item_2->subcategoria_id = 41;
                        $item_2->categoria_id = 8;
                        $item_2->search = 'ECOLOGICOS, ECOLÓGICOS, ECOLOGÍA, RECICLABLE, TÉRMOS, TERMOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item_2->meta_keywords = $item_2->search . ', ' .$producto['meta_keywords'];
                        $item_2->save();

                        $item->subcategoria_id = 95;
                        $item->categoria_id = 14;
                        $item->search = 'ECOLOGICOS, ECOLÓGICOS, ECOLOGÍA, RECICLABLE, TERMOS, TÉRMOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                    else {
                        $item->subcategoria_id = 95;
                        $item->categoria_id = 14;
                        $item->search = 'BEBIDAS, TERMOS, TÉRMOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                        $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                    }
                }
                else {
                    $item->subcategoria_id = 95;
                    $item->categoria_id = 14;
                    $item->search = 'BEBIDAS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
                    $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
                }
            }
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Power Bank')
        {
            $item->subcategoria_id = 6;
            $item->categoria_id = 1;
            $item->search = 'TECNOLOGIA,POWER BANK, TECNOLOGÍA, CARGADOR, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Memorias USB')
        {
            $item->subcategoria_id = 3;
            $item->categoria_id = 1;
            $item->search = 'TECNOLOGIA, USB, TECNOLOGÍA, MEMORIA, MEMÓRIA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Paraguas')
        {
            $item->subcategoria_id = 32;
            $item->categoria_id = 6;
            $item->search = 'PARAGUAS, PARAGUAS E IMPERMEABLES, LLUVIA, LLÚVIA, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Hieleras')
        {
            $item->subcategoria_id = 26;
            $item->categoria_id = 5;
            $item->search = 'TEXTIL, TEXTÍL, LONCHERAS Y HIELERAS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
        }
        else if($producto['categorias']['categorias'][0]['nombre'] == 'Mochilas y Maletas')
        {
            $item->subcategoria_id = 24;
            $item->categoria_id = 5;
            $item->search = 'TEXTIL,TEXTÍL, MOCHILAS Y MALETAS,' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
        }
        else{
            $item->subcategoria_id = 93;
            $item->categoria_id = 20;
            $item->search = 'OTROS, VARIOS, ' . Str::upper($producto['nombre']) . ', '. Str::upper($producto['meta_description']);
            $item->meta_keywords = $item->search . ', ' .$producto['meta_keywords'];
        }

        $item->save();
    }

    private function updateProduct($producto)
    {
        $item = Product::where('code', $producto['codigo'])->first();
        $item->name = $producto['nombre'];
        $item->code = $producto['codigo'];
        $item->parent_code = $producto['codigo'];
        $item->discount = 0.0;
        /* Manipulacion de Colores e Imagenes */
        $images = array();
        $colores = array();
        array_push($images, $producto['imagen_principal']);
        
        foreach ($producto['colores'] as $color) {
            array_push($colores, $color['codigo_color']);
            array_push($images, $color['image']);
        }
        foreach ($producto['images'] as $image) {
            array_push($images, $image['image']);
        }
        foreach ($producto['imagenes_adicionales'] as $image) {
            array_push($images, $image);
        }

        $item->colors = json_encode($colores);
        $item->details = $producto['descripcion'];
        $item->stock = 0;
        $item->price = 0;
        $item->nw = $producto['peso_paquete'];
        $item->gw = 'Sin definir';
        $item->weight_product = $producto['peso_producto'];
        $item->medida_producto_alto = $producto['medidas_producto'];
        $item->printing_area = $producto['area_impresion'];
        $printing_methods = array();
        foreach ($product['tecnicas_impresion'] as $printing) {
            array_push($printing_methods, $printing['codigo']);
        }
        $item->printing_methods = json_encode($printing_methods);
        $item->category = $producto['categorias']['categorias'][0]['nombre'];
        $item->subcategory = $producto['subcategorias']['subcategorias'][0]['nombre'];
        $item->box_pieces = $producto['cantidad_por_paquete'];
        $item->images = $images;
        $item->material = Str::ucfirst($producto['material']);
        $item->save();
    }


}
