<?php

namespace App\Jobs\Proveedores;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
            'api_key' => '76o602ea9d959f1f4awL8R',
            'format' => 'JSON'
        ];

        $response = $this->client->call('Pages', $params);
        //Result send by the endpoint: {"response":true,"code":"SUCCESS","pages":9}
        $response = json_decode($response, true);

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
                    insertProduct($value);
                }
            } else {
                $log = new Logs();
                $log->status = 'Error';
                $log->message = $response['message'] . 'en Innova.';
                $log->save();
                Log::error($response['message'] . 'en Innova.');
            }
        }
    }

    private function insertProduct($producto)
    {
        $item = new Product();
        $item->name = $producto['nombre'];
        $item->code = $producto['codigo'];
        $item->parent_code = $producto['codigo'];
        $item->discount = 0.0;
        $colores = array();
        foreach ($producto['colores'] as $color) {
            array_push($colores, $color['codigo_color']);
        }
        $item->colors = json_encode($colores);
        $item->details = $producto['descripcion'];
        $item->stock = 
        $images = array();
            foreach ($producto['images'] as $img) 
            {
                array_push($images,$img['image']);
            }
            $item->images = json_encode($images);
            $colores = array();
            foreach ($producto['colores'] as $color) {
                array_push($colores,$color['codigo_color']);
            }
            
            $item->proveedor = 'Innova';
            $item->piezas_caja = $producto['cantidad_por_paquete'];
            $item->area_impresion = $producto['area_impresion'];
            $metodos_impresion = '';
            $void = 0;
            foreach ($producto['tecnicas_impresion'] as $impresion) 
            {
                if($void == 0)
                {
                    $metodos_impresion =  $metodos_impresion.''.$impresion['nombre'];
                }
                else if($void + 1 < count($producto['tecnicas_impresion']))
                {
                    $metodos_impresion =  $metodos_impresion.', '.$impresion['nombre'];
                }
                else{
                    $metodos_impresion =  $metodos_impresion.', '.$impresion['nombre'];
                }  
                $void++;  
            }
            $item->metodos_impresion = $metodos_impresion;
            $item->peso_caja = $producto['peso_paquete'];
            $item->medida_producto_ancho = null;
            $item->medida_producto_alto = null;
            $item->medidas_producto_general = null;
            $item->alto_caja = null;
            $item->ancho_caja = null;
            $item->largo_caja = null;
            $item->caja_master = $producto['medidas_paquete'];
            $item->modelo = $producto['codigo'];
            $item->material = $producto['material'];
            $item->capacidad = null;
            $item->promocion = 0;
            $item->file_name = null;
            $item->custom = 0;
            $item->existencias = 0;

            if($producto['categorias']['categorias'][0]['nombre'] == 'Cuidado Personal')
            {
                if(Str::contains($producto['nombre'], 'antibacterial'))
                {
                    $item->categoria_id = 3;
                    $item->subcategoria_id = 94;
                    $item->busqueda = 'SALUD Y CUIDADO PERSONAL,ARTICULOS DE CONTINGENCIA';

                }
                else if(Str::contains($producto['nombre'], 'esterilizadora'))
                {
                    $item->categoria_id = 3;
                    $item->subcategoria_id = 94;
                    $item->busqueda = 'SALUD Y CUIDADO PERSONAL,ARTICULOS DE CONTINGENCIA';

                }
                else {
                    $item->categoria_id = 3;
                    $item->subcategoria_id = 19;
                    $item->busqueda = 'SALUD Y CUIDADO PERSONAL,CUIDADO PERSONAL';
                }
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Belleza')
            {
                $item->subcategoria_id = 17;
                $item->categoria_id = 3;
                $item->busqueda = 'SALUD Y CUIDADO PERSONAL,BELLEZA';
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
                            $item->busqueda = 'BOLIGRAFOS,BOLIGRAFOS METALICOS'; 
                        }
                        else if($producto['material'] == 'CARTON' || $producto['material'] == 'BAMBOO' || $producto['material'] == 'CORCHO' || $producto['material'] == 'FIBRA DE TRIGO')
                        {
                            $item_2 = new Producto();
                            $item_2->nombre = $producto['nombre'];
                            $item_2->nickname = $producto['nombre'];
                            $item_2->SDK = $producto['codigo'];
                            $item_2->descripcion = $producto['descripcion'];
                            $item_2->images = $item->images;
                            $item_2->color = $item->color;
                            $item_2->proveedor = 'Innova';
                            $item_2->piezas_caja = $producto['cantidad_por_paquete'];
                            $item_2->area_impresion = $producto['area_impresion'];
                            $item_2->metodos_impresion = $item->metodos_impresion;
                            $item_2->peso_caja = $producto['peso_paquete'];
                            $item_2->medida_producto_ancho = null;
                            $item_2->medida_producto_alto = null;
                            $item_2->medidas_producto_general = null;
                            $item_2->alto_caja = null;
                            $item_2->ancho_caja = null;
                            $item_2->largo_caja = null;
                            $item_2->caja_master = $producto['medidas_paquete'];
                            $item_2->modelo = $producto['codigo'];
                            $item_2->material = $producto['material'];
                            $item_2->capacidad = null;
                            $item_2->promocion = 0;
                            $item_2->file_name = null;
                            $item_2->custom = 0;
                            $item_2->existencias = 0;
                            $item_2->subcategoria_id = 37;
                            $item_2->categoria_id = 8;
                            $item_2->busqueda = 'ECOLOGICOS,BOLIGRAFOS ECOLOGICOS'; 
                            $item_2->save();

                            $item->subcategoria_id = 10;
                            $item->categoria_id = 2;
                            $item->busqueda = 'BOLIGRAFOS,BOLIGRAFOS ECOLOGICOS';
                        }
                        else if($producto['material'] == 'PLÁSTICO')
                        {
                            $item->subcategoria_id = 9;
                            $item->categoria_id = 2;
                            $item->busqueda = 'BOLIGRAFOS,BOLIGRAFOS DE PLASTICO'; 
                        }
                        else 
                        {
                            $item->subcategoria_id = 15;
                            $item->categoria_id = 2;
                            $item->busqueda = 'BOLIGRAFOS,OTROS BOLIGRAFOS'; 
                        }
                    }
                    else if($producto['categorias']['subcategorias'][0]['codigo'] == 'marca-textos')
                    {
                        $item->subcategoria_id = 55;
                        $item->categoria_id = 10;
                        $item->busqueda = 'OFICINA,MARCA TEXTOS'; 
                    }
                }
                else{
                    if($producto['material'] == 'METAL' || $producto['material'] == 'ALUMINIO')
                    {
                        $item->subcategoria_id = 7;
                        $item->categoria_id = 2;
                        $item->busqueda = 'BOLIGRAFOS,BOLIGRAFOS METALICOS'; 
                    }
                    else if($producto['material'] == 'CARTON' || $producto['material'] == 'BAMBOO' || $producto['material'] == 'CORCHO' || $producto['material'] == 'FIBRA DE TRIGO')
                    {
                        $item_2 = new Producto();
                        $item_2->nombre = $producto['nombre'];
                        $item_2->nickname = $producto['nombre'];
                        $item_2->SDK = $producto['codigo'];
                        $item_2->descripcion = $producto['descripcion'];
                        $item_2->images = $item->images;
                        $item_2->color = $item->color;
                        $item_2->proveedor = 'Innova';
                        $item_2->piezas_caja = $producto['cantidad_por_paquete'];
                        $item_2->area_impresion = $producto['area_impresion'];
                        $item_2->metodos_impresion = $item->metodos_impresion;
                        $item_2->peso_caja = $producto['peso_paquete'];
                        $item_2->medida_producto_ancho = null;
                        $item_2->medida_producto_alto = null;
                        $item_2->medidas_producto_general = null;
                        $item_2->alto_caja = null;
                        $item_2->ancho_caja = null;
                        $item_2->largo_caja = null;
                        $item_2->caja_master = $producto['medidas_paquete'];
                        $item_2->modelo = $producto['codigo'];
                        $item_2->material = $producto['material'];
                        $item_2->capacidad = null;
                        $item_2->promocion = 0;
                        $item_2->file_name = null;
                        $item_2->custom = 0;
                        $item_2->existencias = 0;
                        $item_2->subcategoria_id = 37;
                        $item_2->categoria_id = 8;
                        $item_2->busqueda = 'ECOLOGICOS,BOLIGRAFOS ECOLOGICOS'; 
                        $item_2->save();

                        $item->subcategoria_id = 10;
                        $item->categoria_id = 2;
                        $item->busqueda = 'BOLIGRAFOS,BOLIGRAFOS ECOLOGICOS'; 
                    }
                    else if($producto['material'] == 'PLÁSTICO')
                    {
                        $item->subcategoria_id = 9;
                        $item->categoria_id = 2;
                        $item->busqueda = 'BOLIGRAFOS,BOLIGRAFOS DE PLASTICO'; 
                    }
                    else {
                        $item->subcategoria_id = 15;
                        $item->categoria_id = 2;
                        $item->busqueda = 'BOLIGRAFOS,BOLIGRAFOS'; 
                    }
                }
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Oficina')
            {
                if(Str::contains($producto['nombre'], 'Libreta ecológica'))
                {
                    $item_2 = new Producto();
                    $item_2->nombre = $producto['nombre'];
                    $item_2->nickname = $producto['nombre'];
                    $item_2->SDK = $producto['codigo'];
                    $item_2->descripcion = $producto['descripcion'];
                    $item_2->images = $item->images;
                    $item_2->color = $item->color;
                    $item_2->proveedor = 'Innova';
                    $item_2->piezas_caja = $producto['cantidad_por_paquete'];
                    $item_2->area_impresion = $producto['area_impresion'];
                    $item_2->metodos_impresion = $item->metodos_impresion;
                    $item_2->peso_caja = $producto['peso_paquete'];
                    $item_2->medida_producto_ancho = null;
                    $item_2->medida_producto_alto = null;
                    $item_2->medidas_producto_general = null;
                    $item_2->alto_caja = null;
                    $item_2->ancho_caja = null;
                    $item_2->largo_caja = null;
                    $item_2->caja_master = $producto['medidas_paquete'];
                    $item_2->modelo = $producto['codigo'];
                    $item_2->material = $producto['material'];
                    $item_2->capacidad = null;
                    $item_2->promocion = 0;
                    $item_2->file_name = null;
                    $item_2->custom = 0;
                    $item_2->existencias = 0;
                    $item_2->subcategoria_id = 38;
                    $item_2->categoria_id = 8;
                    $item_2->busqueda = 'ECOLOGICOS,LIBRETAS ECOLOGICAS'; 
                    $item_2->save();

                    $item->subcategoria_id = 48;
                    $item->categoria_id = 10;
                    $item->busqueda = 'OFICINA,LIBRETAS';

                }
                else if(Str::contains($producto['nombre'], 'Porta gafete'))
                {
                    $item->subcategoria_id = 53;
                    $item->categoria_id = 10;
                    $item->busqueda = 'OFICINA,LIBRETAS';
                }
                else if(Str::contains($producto['nombre'], 'Cubo ecológico'))
                {
                    $item_2 = new Producto();
                    $item_2->nombre = $producto['nombre'];
                    $item_2->nickname = $producto['nombre'];
                    $item_2->SDK = $producto['codigo'];
                    $item_2->descripcion = $producto['descripcion'];
                    $item_2->images = $item->images;
                    $item_2->color = $item->color;
                    $item_2->proveedor = 'Innova';
                    $item_2->piezas_caja = $producto['cantidad_por_paquete'];
                    $item_2->area_impresion = $producto['area_impresion'];
                    $item_2->metodos_impresion = $item->metodos_impresion;
                    $item_2->peso_caja = $producto['peso_paquete'];
                    $item_2->medida_producto_ancho = null;
                    $item_2->medida_producto_alto = null;
                    $item_2->medidas_producto_general = null;
                    $item_2->alto_caja = null;
                    $item_2->ancho_caja = null;
                    $item_2->largo_caja = null;
                    $item_2->caja_master = $producto['medidas_paquete'];
                    $item_2->modelo = $producto['codigo'];
                    $item_2->material = $producto['material'];
                    $item_2->capacidad = null;
                    $item_2->promocion = 0;
                    $item_2->file_name = null;
                    $item_2->custom = 0;
                    $item_2->existencias = 0;
                    $item_2->subcategoria_id = 41;
                    $item_2->categoria_id = 8;
                    $item_2->busqueda = 'ECOLOGICOS,OTROS ECOLOGICOS'; 
                    $item_2->save();

                    $item->subcategoria_id = 47;
                    $item->categoria_id = 10;
                    $item->busqueda = 'OFICINA,LIBRETAS';
                }
                else 
                {
                    $item->subcategoria_id = 47;
                    $item->categoria_id = 10;
                    $item->busqueda = 'OFICINA,ARTICULOS DE OFICINA';
                }
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Libretas')
            {
                $item->subcategoria_id = 48;
                $item->categoria_id = 10;
                $item->busqueda = 'OFICINA,LIBRETAS';
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Ejecutiva')
            {
                if(Str::contains($producto['nombre'], 'Carpeta'))
                {
                    $item->subcategoria_id = 49;
                    $item->categoria_id = 10;
                    $item->busqueda = 'OFICINA,CARPETA';
                }
                else if(Str::contains($producto['nombre'], 'Maletín'))
                {
                    $item->subcategoria_id = 29;
                    $item->categoria_id = 5;
                    $item->busqueda = 'TEXTIL,MALETINES';
                }
                else if(Str::contains($producto['nombre'], 'Mochila'))
                {
                    $item->subcategoria_id = 24;
                    $item->categoria_id = 5;
                    $item->busqueda = 'TEXTIL,MOCHILAS';
                }
                else if(Str::contains($producto['nombre'], 'Portafolio') || Str::contains($producto['nombre'], 'Maleta'))
                {
                    $item->subcategoria_id = 28;
                    $item->categoria_id = 5;
                    $item->busqueda = 'TEXTIL,PORTAFOLIOS';
                }
                else if(Str::contains($producto['nombre'], 'Libreta'))
                {
                    $item->subcategoria_id = 48;
                    $item->categoria_id = 10;
                    $item->busqueda = 'OFICINA,LIBRETAS';
                }
                else 
                {
                    $item->subcategoria_id = 47;
                    $item->categoria_id = 10;
                    $item->busqueda = 'EJECUTIVA';
                }
                
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Viaje')
            {
                $item->subcategoria_id = 20;
                $item->categoria_id = 4;
                $item->busqueda = 'VIAJE,ACCESORIOS DE VIAJE';
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Herramientas')
            {
                if(Str::contains($producto['nombre'], 'Navaja'))
                {
                    $item->subcategoria_id = 35;
                    $item->categoria_id = 7;
                    $item->busqueda = 'HERRAMIENTAS,NAVAJAS MULTIFUNCIONALES';
                }
                else if(Str::contains($producto['nombre'], 'Llavero'))
                {
                    if($producto['material'] == 'ACERO')
                    {
                        $item->subcategoria_id = 80;
                        $item->categoria_id = 15;
                        $item->busqueda = 'LLAVEROS,LLAVEROS METALICOS';
                    }
                    else if($producto['material'] == 'PLÁSTICO')
                    {
                        $item->subcategoria_id = 81;
                        $item->categoria_id = 15;
                        $item->busqueda = 'LLAVEROS,LLAVEROS PLASTICO';
                    }
                    else {
                        $item->subcategoria_id = 84;
                        $item->categoria_id = 15;
                        $item->busqueda = 'LLAVEROS,OTROS LLAVEROS';
                    }
                }
                else if(Str::contains($producto['nombre'], 'Lámpara'))
                {
                    $item->subcategoria_id = 34;
                    $item->categoria_id = 7;
                    $item->busqueda = 'HERRAMIENTAS,LAMPARAS';
                }
                else {
                    $item->subcategoria_id = 33;
                    $item->categoria_id = 7;
                    $item->busqueda = 'HERRAMIENTAS,HERRAMIENTAS';
                }
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Bar')
            {
                if(Str::contains($producto['nombre'], 'Hielera'))
                {
                    $item->subcategoria_id = 26;
                    $item->categoria_id = 5;
                    $item->busqueda = 'TEXTIL,LONCHES Y HIELERAS';
                }
                if(Str::contains($producto['nombre'], 'Llavero'))
                {
                    if($producto['material'] == 'METAL')
                    {
                        $item->subcategoria_id = 80;
                        $item->categoria_id = 15;
                        $item->busqueda = 'LLAVEROS,LLAVEROS METALICOS';
                    }
                    else {
                        $item->subcategoria_id = 84;
                        $item->categoria_id = 15;
                        $item->busqueda = 'LLAVEROS,OTROS LLAVEROS';
                    }
                }
                else {
                    $item->subcategoria_id = 43;
                    $item->categoria_id = 9;
                    $item->busqueda = 'HOGAR,BAR';
                }
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Sets de Regalo')
            {
                if(Str::contains($producto['nombre'], 'BBQ'))
                {
                    $item->subcategoria_id = 44;
                    $item->categoria_id = 9;
                    $item->busqueda = 'HOGAR,BBQ';
                }
                else {
                    $item->subcategoria_id = 93;
                    $item->categoria_id = 20;
                    $item->busqueda = 'SET DE REGALO';
                }
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Escolares y Niños')
            {
                $item->subcategoria_id = 92;
                $item->categoria_id = 19;
                $item->busqueda = 'KIDS Y ESCOLARES,ESCOLARES';
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Hogar')
            {
                if(Str::contains($producto['nombre'], 'BBQ'))
                {
                    $item->subcategoria_id = 44;
                    $item->categoria_id = 9;
                    $item->busqueda = 'HOGAR,BBQ';
                }else {
                    $item->subcategoria_id = 45;
                    $item->categoria_id = 9;
                    $item->busqueda = 'HOGAR,OTROS HOGAR';
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
                        $item->busqueda = 'RELOJES,ESTUCHES'; 
                    }
                    else if($producto['categorias']['subcategorias'][0]['codigo'] == 'pared-y-escritorio')
                    {
                        $item->subcategoria_id = 87;
                        $item->categoria_id = 17;
                        $item->busqueda = 'RELOJES,PARED Y ESCRITORIO'; 
                    }
                    else if($producto['categorias']['subcategorias'][0]['codigo'] == 'relojes-de-pulso')
                    {
                        $item->subcategoria_id = 88;
                        $item->categoria_id = 17;
                        $item->busqueda = 'RELOJES,RELOJ DE PULSO'; 
                    }
                }
                else
                {
                    $item->subcategoria_id = 97;
                    $item->categoria_id = 17;
                    $item->busqueda = 'RELOJES,OTROS RELOJES';
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
                        $item->busqueda = 'LLAVEROS,LLAVEROS METALICOS';
                    }
                    else if($producto['material'] == 'PLÁSTICO')
                    {
                        $item->subcategoria_id = 81;
                        $item->categoria_id = 15;
                        $item->busqueda = 'LLAVEROS,LLAVEROS PLASTICO';
                    }
                    else if($producto['material'] == 'BAMBOO')
                    {
                        $item_2 = new Producto();
                        $item_2->nombre = $producto['nombre'];
                        $item_2->nickname = $producto['nombre'];
                        $item_2->SDK = $producto['codigo'];
                        $item_2->descripcion = $producto['descripcion'];
                        $item_2->images = $item->images;
                        $item_2->color = $item->color;
                        $item_2->proveedor = 'Innova';
                        $item_2->piezas_caja = $producto['cantidad_por_paquete'];
                        $item_2->area_impresion = $producto['area_impresion'];
                        $item_2->metodos_impresion = $item->metodos_impresion;
                        $item_2->peso_caja = $producto['peso_paquete'];
                        $item_2->medida_producto_ancho = null;
                        $item_2->medida_producto_alto = null;
                        $item_2->medidas_producto_general = null;
                        $item_2->alto_caja = null;
                        $item_2->ancho_caja = null;
                        $item_2->largo_caja = null;
                        $item_2->caja_master = $producto['medidas_paquete'];
                        $item_2->modelo = $producto['codigo'];
                        $item_2->material = $producto['material'];
                        $item_2->capacidad = null;
                        $item_2->promocion = 0;
                        $item_2->file_name = null;
                        $item_2->custom = 0;
                        $item_2->existencias = 0;
                        $item_2->subcategoria_id = 41;
                        $item_2->categoria_id = 8;
                        $item_2->busqueda = 'ECOLOGICOS,OTROS ECOLOGICOS'; 
                        $item_2->save();

                        $item->subcategoria_id = 84;
                        $item->categoria_id = 15;
                        $item->busqueda = 'LLAVEROS,OTROS LLAVEROS';
                    }
                    else {
                        $item->subcategoria_id = 84;
                        $item->categoria_id = 15;
                        $item->busqueda = 'LLAVEROS,OTROS LLAVEROS';
                    }
                }
                else {
                    $item->subcategoria_id = 84;
                    $item->categoria_id = 15;
                    $item->busqueda = 'LLAVEROS,OTROS LLAVEROS';
                }
                
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Tecnología')
            {
                if(Str::contains($producto['descripcion'], 'Memoria USB'))
                {
                    $item->subcategoria_id = 3;
                    $item->categoria_id = 1;
                    $item->busqueda = 'TECNOLOGIA,USB';
                }
                else if(Str::contains($producto['nombre'], 'Audífonos') || $producto['nombre']== 'Audífono')
                {
                    $item->subcategoria_id = 1;
                    $item->categoria_id = 1;
                    $item->busqueda = 'TECNOLOGIA,AUDÍFONOS';
                }
                else if(Str::contains($producto['nombre'], 'Cargador'))
                {
                    $item->subcategoria_id = 5;
                    $item->categoria_id = 1;
                    $item->busqueda = 'TECNOLOGIA,ACCESORIOS DE SMARTPHONE';
                }
                else {
                    $item->subcategoria_id = 6;
                    $item->categoria_id = 1;
                    $item->busqueda = 'TECNOLOGIA,OTROS TECNOLOGIA';
                }
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Antiestrés')
            {
                $item->subcategoria_id = 59;
                $item->categoria_id = 12;
                $item->busqueda = 'ANTIESTRES,ANTIESTRES';
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Bebidas')
            {
                if(count($producto['categorias']['subcategorias']) > 0)
                {
                    if($producto['categorias']['subcategorias'][0]['codigo'] == 'tazas')
                    {
                        $item->subcategoria_id = 74;
                        $item->categoria_id = 14;
                        $item->busqueda = 'BEBIDAS,TAZAS Y TARROS'; 
                    }
                    else if($producto['categorias']['subcategorias'][0]['codigo'] == 'termos')
                    {
                        if($producto['material'] == 'PLÁSTICO')
                        {
                            $item->subcategoria_id = 76;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,TERMOS PLASTICOS';
                        }
                        else if($producto['material'] == 'METAL' || $producto['material'] == 'ACERO' || $producto['material'] == 'TRITAN')
                        {
                            $item->subcategoria_id = 77;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,TERMOS METALICOS';
                        }
                        else {
                            $item->subcategoria_id = 95;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,TERMOS'; 
                        }
                    }
                    else if($producto['categorias']['subcategorias'][0]['codigo'] == 'cilindros')
                    {
                        if($producto['material'] == 'POLICARBONATO')
                        {
                            $item->subcategoria_id = 71;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,CILINDROS PLASTICOS';
                        }
                        else if($producto['material'] == 'TRITAN' || $producto['material'] == 'ACERO')
                        {
                            $item->subcategoria_id = 72;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,CILINDROS METALICOS';
                        }
                        else if($producto['material'] == 'VIDRIO')
                        {
                            $item->subcategoria_id = 73;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,CILINDROS DE VIDRIO';
                        }
                        else {
                            $item->subcategoria_id = 71;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,CILINDROS UNKNOW';
                        }
                    }
                    else if($producto['categorias']['subcategorias'][0]['codigo'] == 'vasos')
                    {
                        $item->subcategoria_id = 75;
                        $item->categoria_id = 14;
                        $item->busqueda = 'BEBIDAS,VASOS'; 
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
                            $item->busqueda = 'BEBIDAS,CILINDROS PLASTICOS';
                        }
                        else if($producto['material'] == 'TRITAN')
                        {
                            $item->subcategoria_id = 72;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,CILINDROS METALICOS';
                        }
                        else {
                            $item->subcategoria_id = 71;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,CILINDROS UNKNOW';
                        }
                    }
                    else if(Str::contains($producto['nombre'], 'Termo'))
                    {
                        if($producto['material'] == 'BAMBOO' ||$producto['material'] == 'FIBRA DE TRIGO')
                        {
                            $item_2 = new Producto();
                            $item_2->nombre = $producto['nombre'];
                            $item_2->nickname = $producto['nombre'];
                            $item_2->SDK = $producto['codigo'];
                            $item_2->descripcion = $producto['descripcion'];
                            $item_2->images = $item->images;
                            $item_2->color = $item->color;
                            $item_2->proveedor = 'Innova';
                            $item_2->piezas_caja = $producto['cantidad_por_paquete'];
                            $item_2->area_impresion = $producto['area_impresion'];
                            $item_2->metodos_impresion = $item->metodos_impresion;
                            $item_2->peso_caja = $producto['peso_paquete'];
                            $item_2->medida_producto_ancho = null;
                            $item_2->medida_producto_alto = null;
                            $item_2->medidas_producto_general = null;
                            $item_2->alto_caja = null;
                            $item_2->ancho_caja = null;
                            $item_2->largo_caja = null;
                            $item_2->caja_master = $producto['medidas_paquete'];
                            $item_2->modelo = $producto['codigo'];
                            $item_2->material = $producto['material'];
                            $item_2->capacidad = null;
                            $item_2->promocion = 0;
                            $item_2->file_name = null;
                            $item_2->custom = 0;
                            $item_2->existencias = 0;
                            $item_2->subcategoria_id = 41;
                            $item_2->categoria_id = 8;
                            $item_2->busqueda = 'ECOLOGICOS,OTROS ECOLOGICOS'; 
                            $item_2->save();

                            $item->subcategoria_id = 95;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,TERMOS ECOLOGICOS';
                        }
                        else {
                            $item->subcategoria_id = 95;
                            $item->categoria_id = 14;
                            $item->busqueda = 'BEBIDAS,TERMOS';
                        }
                    }
                    else {
                        $item->subcategoria_id = 95;
                        $item->categoria_id = 14;
                        $item->busqueda = 'BEBIDAS,OTROS';
                    }
                }
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Power Bank')
            {
                $item->subcategoria_id = 6;
                $item->categoria_id = 1;
                $item->busqueda = 'TECNOLOGIA,POWER BANK';
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Memorias USB')
            {
                $item->subcategoria_id = 3;
                $item->categoria_id = 1;
                $item->busqueda = 'TECNOLOGIA,USB';
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Paraguas')
            {
                $item->subcategoria_id = 32;
                $item->categoria_id = 6;
                $item->busqueda = 'PARAGUAS,PARAGUAS E IMPERMEABLES';
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Hieleras')
            {
                $item->subcategoria_id = 26;
                $item->categoria_id = 5;
                $item->busqueda = 'TEXTIL,LONCHERAS Y HIELERAS';
            }
            else if($producto['categorias']['categorias'][0]['nombre'] == 'Mochilas y Maletas')
            {
                $item->subcategoria_id = 24;
                $item->categoria_id = 5;
                $item->busqueda = 'TEXTIL,MOCHILAS Y MALETAS';
            }
            else{
                $item->subcategoria_id = 93;
                $item->categoria_id = 20;
                $item->busqueda = 'OTROS,VARIOS';
            }

            $item->save();

    }
}
