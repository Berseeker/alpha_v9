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

//Para conexiones a la API
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;

use App\Models\Product;
use App\Models\Logs;

class InsertForPromotional implements ShouldQueue
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
        $service_url = 'https://4promotional.net:9090/WsEstrategia/inventario';
        $curl = curl_init ( $service_url );
        $options = array (
            CURLOPT_RETURNTRANSFER => true, // true to return the result as string of value
            CURLOPT_HTTPHEADER => array (
                'Content-Type: application/json'
            )
        );
        curl_setopt_array ( $curl, $options ); //setting options for curl request
        curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, "GET" ); //sending the request as post/get

        // connect to the link via SSL without checking certificate
        curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false); //false will prevent curl from verifying the SSL certificate

        $response_json = curl_exec ( $curl ); //execute curl
        curl_close ( $curl );
        $response = json_decode($response_json ,true); //decoding the response in json format

        $cont_new_products = 0; #Contador global
        $cont_update_products = 0; #Contador global
        foreach ($response as $producto) 
        {
            $product = Product::where('parent_code', $producto['id_articulo'])->first();
            if($product == null){
                $this->insertProduct($producto, $cont_new_products);
            } else {
                $this->updateProduct($producto, $cont_update_products);
            }  
        }

        $msg = '';
        if ($cont_new_products > 0) {
            $msg = $msg.$cont_new_products. ' productos nuevos';
        }
        if ($cont_update_products > 0) {
            $msg = $msg. ' y se actualizaron '. $cont_update_products. ' productos';
        }


        $log = new Logs();
        $log->status = 'success';
        $log->message = 'Se agregaron '.$msg.' de ForPromotional';
        $log->save();

        Log::info('Se agregaron '.$msg.' de ForPromotional');
    }

    private function insertProduct($item, &$cont_new_products) {

        $product = new Product();
        $product->name = $item['nombre_articulo'];
        $product->code = $item['id_articulo'];
        $product->parent_code = $item['id_articulo'];
        $product->discount = $item['desc_promo'];
        $colors = [];
        array_push($colors, trim(Str::upper($item['color'])));
        $product->colors = json_encode($colors);
        $product->details = $item['descripcion'];
        $product->stock = $item['inventario'];
        $product->price = $item['precio'];
        $product->nw = $item['peso_caja'];
        $product->printing_area = $item['area_impresion'];

        $printing = [];
        $metodos_impresion = explode('-', $item['metodos_impresion']);
        foreach ($metodos_impresion as $impresion) {
            array_push($printing, trim($impresion));
        }
        $product->printing_methods = json_encode($printing);
        $product->category = $item['categoria'];
        $product->subcategory = $item['sub_categoria'];
        $product->box_pieces = $item['piezas_caja'];
        $product->capacity = ($item['capacidad'] != "") ? $item['capacidad'] : null;

        $images = [];
        foreach ($item['imagenes'] as $imagen) {
            if (array_key_exists('url_imagen', $imagen) && !empty($imagen['url_imagen'])) {
                array_push($images, $imagen['url_imagen']);
            }
        }
        $product->images = json_encode($images);
        $product->proveedor = 'ForPromotional';
        
        $result = $this->setFamily($item);
        if ($result == null) {
            $product->categoria_id = 20;
            $product->subcategoria_id = 93;
        }
            
        $product->categoria_id = $result['category_id'];
        $product->subcategoria_id = $result['subcategory_id'];
        $product->search = $result['search'];
        $product->save();

        $cont_new_products++;

    }

    private function updateProduct($item, &$cont_update_products) {

        $product = Product::where('parent_code', $item['id_articulo'])->first();
        $colors = json_decode($product->colors);
        
        $pointer = false;
        foreach ($colors as $color) {

            if (trim(Str::upper($item['color'])) === $color ) {
                $pointer = true;;
            }
        }

        if (!$pointer) {
            array_push($colors, trim(Str::upper($item['color'])));
        }
        
      
        $product->colors = json_encode($colors);
        $product->save();

        $cont_update_products++;
    }

    private function setFamily($producto) {

        if($producto['categoria'] == "TECNOLOGÍA"){
            
            switch ($producto['sub_categoria']) {
                case 'AUDÍFONOS':
                    return [
                        'category_id' => 1,
                        'subcategory_id' => 1,
                        'search' =>  $producto['categoria'].','.$producto['sub_categoria'].',HEADPHONES,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'ÚNICA':
                    return [
                        'category_id' => 1,
                        'subcategory_id' => 6,
                        'search' =>  $producto['categoria'].','.$producto['sub_categoria'].','.$producto['nombre_articulo']
                    ];
                    break;
                case 'BOCINAS':
                    return [
                        'category_id' => 1,
                        'subcategory_id' => 2,
                        'search' =>  $producto['categoria'].','.$producto['sub_categoria'].','.$producto['nombre_articulo']
                    ];
                    break;
                case 'USB':
                    return [
                        'category_id' => 1,
                        'subcategory_id' => 3,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',MEMORIA USB,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'ACCESORIOS Y CARGADORES':
                    return [
                        'category_id' => 1,
                        'subcategory_id' => 4,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',CABLE USB,CARGADOR,ACCESORIO,ADAPTADOR,PUERTO,CELULAR,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'POWER BANKS':
                    return [
                        'category_id' => 1,
                        'subcategory_id' => 5,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',BATERIA PORTATIL,'.$producto['nombre_articulo']
                    ];
                    break;
                
                default:
                    return [
                        'category_id' => 1,
                        'subcategory_id' => 6,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].','.$producto['nombre_articulo']
                    ];
                    break;
            }
            //----------------- 1.- TECNOLOGÍA
            // 1.- AUDÍFONOS
            //2.- ÚNICA
            //3.- BOCINAS
            //4.- USB
            //5.- ACCESORIOS Y CARGADORES
            //6.- POWER BANKS
        }

        if($producto['categoria'] == "BOLÍGRAFOS"){
            
            switch ($producto['sub_categoria']) {
                case 'BOLÍGRAFOS METÁLICOS':
                    return [
                        'category_id' => 2,
                        'subcategory_id' => 7,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',BOLIGRAFO METALICO,BOLIGRAFO DE METAL,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'BOLÍGRAFOS MULTIFUNCIONALES':
                    return [
                        'category_id' => 2,
                        'subcategory_id' => 8,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',BOLIGRAFO MULTIFUNCIONAL,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'BOLÍGRAFOS DE PLÁSTICO':
                    return [
                        'category_id' => 2,
                        'subcategory_id' => 9,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'BOLÍGRAFOS ECOLÓGICOS':
                    
                    $product = new Product;
                    $product->name = $producto['nombre_articulo'];
                    $product->code = $producto['id_articulo'];
                    $product->parent_code = $producto['id_articulo'];
                    $product->discount = $producto['desc_promo'];
                    $colors = [];
                    array_push($colors, trim(Str::upper($producto['color'])));
                    $product->colors = json_encode($colors);
                    $product->details = $producto['descripcion'];
                    $product->stock = $producto['inventario'];
                    $product->price = $producto['precio'];
                    $product->nw = $producto['peso_caja'];
                    $product->printing_area = $producto['area_impresion'];

                    $printing = [];
                    $metodos_impresion = explode('-', $producto['metodos_impresion']);
                    foreach ($metodos_impresion as $impresion) {
                        array_push($printing, trim($impresion));
                    }
                    $product->printing_methods = json_encode($printing);
                    $product->category = $producto['categoria'];
                    $product->subcategory = $producto['sub_categoria'];
                    $product->box_pieces = $producto['piezas_caja'];
                    $product->capacity = ($producto['capacidad'] != "") ? $producto['capacidad'] : null;

                    $images = [];
                    foreach ($producto['imagenes'] as $imagen) {
                        if (array_key_exists('url_imagen', $imagen) && !empty($imagen['url_imagen'])) {
                            array_push($images, $imagen['url_imagen']);
                        }
                    }
                    $product->images = json_encode($images);
                    $product->proveedor = 'ForPromotional';

                    $product->categoria_id = 8;
                    $product->subcategoria_id = 37;
                    $product->search = $producto['categoria'].','.$producto['sub_categoria'].',ECOLOGICO,BOLIGRAFO ECOLOGICO,'.$producto['nombre_articulo'];
                    $product->save();

                    return [
                        'category_id' => 2,
                        'subcategory_id' => 10,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',BOLIGRAFO ECOLOGICO,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'BOLÍGRAFOS PLÁSTICO':
                    return [
                        'category_id' => 2,
                        'subcategory_id' => 9,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',BOLIGRAFOS DE PLASTICO,BOLIGRAFO DE PLASTICO,'.$producto['nombre_articulo']
                    ];
                    break;   
                default:
                    return [
                        'category_id' => 2,
                        'subcategory_id' => 15,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',OTROS BOLIGRAFOS,BOLIGRAFO,'.$producto['nombre_articulo']
                    ];
                    break;
            } 
            //--------------- BOLIGRAFOS
            //BOLÍGRAFOS METÁLICOS
            //BOLÍGRAFOS MULTIFUNCIONALES
            //BOLÍGRAFOS DE PLÁSTICO
            //BOLÍGRAFOS ECOLÓGICOS
            //BOLÍGRAFOS PLÁSTICO
            
        }

        if($producto['categoria'] == "SALUD Y CUIDADO PERSONAL"){
            
            switch ($producto['sub_categoria']) {
                case 'SALUD':
                    $subcategoria = 16;
                    $string = '';
                    if(Str::contains($producto['descripcion'],"Cubre bocas") || Str::contains($producto['descripcion'],"Termómetro") || Str::contains($producto['descripcion'],"antibacterial") || Str::contains($producto['descripcion'],"Careta")){
                        $subcategoria = 94;
                    }
                    if(Str::contains($producto['descripcion'],"Cubre bocas"))
                    {
                        $string = 'CUBREBOCAS,CUBRE BOCAS,MASCARILLA,KN95,KN 95,MASK';
                    }
                    else if(Str::contains($producto['descripcion'],"gel antibacterial"))
                    {
                        $string = 'SANITIZANTE,GEL ANTIBACTERIAL';
                    }
                    else if(Str::contains($producto['descripcion'],"careta"))
                    {
                        $string = 'CARETA,MASK';
                    }
                    return [
                        'category_id' => 3,
                        'subcategory_id' => $subcategoria,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].','.$producto['nombre_articulo'].','.$string
                    ];
                    break;
                case 'BELLEZA':
                    $string = '';
                    if(Str::contains($producto['descripcion'],"brochas para maquillaje"))
                    {
                        $string = 'SET DE BROCHAS,BROCHAS,BROCHA,MAQUILLAJE';
                    }
                    else if(Str::contains($producto['descripcion'],"set de") || Str::contains($producto['descripcion'],"manicure"))
                    {
                        $string = 'CORTAUÑAS,CORTA UÑAS,CORTA UÑA,CORTAUÑA,MANICURE,SET DE MANICURE,ESTUCHE DE MANICURE';
                    }
                    else if(Str::contains($producto['descripcion'],"espejo"))
                    {
                        $string = 'ESPEJO';
                    }
                    else if(Str::contains($producto['descripcion'],"cepillo"))
                    {
                        $string = 'CEPILLO,PEINE';
                    }
                    return [
                        'category_id' => 3,
                        'subcategory_id' => 17,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].','.$producto['nombre_articulo'].','.$string
                    ];
                    break;
                case 'COSMETIQUERAS':
                    return [
                        'category_id' => 3,
                        'subcategory_id' => 18,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',MAQUILLAJE,COSMETIQUERA,COSMETICO,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'CUIDADO PERSONAL':
                    return [
                        'category_id' => 3,
                        'subcategory_id' => 19,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].'LIMPIEZA,LIMPIADOR,COSTURA,COSER,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'VIAJE':
                    return [
                        'category_id' => 4,
                        'subcategory_id' => 20,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',VIAJAR'
                    ];
                    break;
                
                default:
                    return [
                        'category_id' => 3,
                        'subcategory_id' => 16,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
            }
            //------------- SALUD Y CUIDADO PERSONAL
            //SALUD
            //BELLEZA
            //COSMETIQUERAS
            //CUIDADO PERSONAL
            //VIAJE
            
        }

        if($producto['categoria'] == "TEXTIL"){
            
            switch ($producto['sub_categoria']) {
                case 'BOLSAS Y MORRALES':
                    return [
                        'category_id' => 5,
                        'subcategory_id' => 22,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].'BOLSA,MORRAL,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'BOLSAS ECOLÓGICAS':
                    $product = new Product;
                    $product->name = $producto['nombre_articulo'];
                    $product->code = $producto['id_articulo'];
                    $product->parent_code = $producto['id_articulo'];
                    $product->discount = $producto['desc_promo'];
                    $colors = [];
                    array_push($colors, trim(Str::upper($producto['color'])));
                    $product->colors = json_encode($colors);
                    $product->details = $producto['descripcion'];
                    $product->stock = $producto['inventario'];
                    $product->price = $producto['precio'];
                    $product->nw = $producto['peso_caja'];
                    $product->printing_area = $producto['area_impresion'];

                    $printing = [];
                    $metodos_impresion = explode('-', $producto['metodos_impresion']);
                    foreach ($metodos_impresion as $impresion) {
                        array_push($printing, trim($impresion));
                    }
                    $product->printing_methods = json_encode($printing);
                    $product->category = $producto['categoria'];
                    $product->subcategory = $producto['sub_categoria'];
                    $product->box_pieces = $producto['piezas_caja'];
                    $product->capacity = ($producto['capacidad'] != "") ? $producto['capacidad'] : null;

                    $images = [];
                    foreach ($producto['imagenes'] as $imagen) {
                        if (array_key_exists('url_imagen', $imagen) && !empty($imagen['url_imagen'])) {
                            array_push($images, $imagen['url_imagen']);
                        }
                    }
                    $product->images = json_encode($images);
                    $product->proveedor = 'ForPromotional';

                    $product->categoria_id = 8;
                    $product->subcategoria_id = 40;
                    $product->search = 'ECOLOGIA,'.$producto['categoria'].','.$producto['sub_categoria'].',BOLSA ECOLOGICA'.$producto['nombre_articulo'];
                    $product->save();
                    return [
                        'category_id' => 5,
                        'subcategory_id' => 23,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].'BOLSA ECOLOGICA'
                    ];
                    break;
                case 'MOCHILAS':
                    return [
                        'category_id' => 5,
                        'subcategory_id' => 24,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',MOCHILA,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'MALETAS':
                    return [
                        'category_id' => 5,
                        'subcategory_id' => 25,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',MALETA,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'LONCHERAS Y HIELERAS':
                    return [
                        'category_id' => 5,
                        'subcategory_id' => 26,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',LONCHERA,HIELERA'.$producto['nombre_articulo']
                    ];
                    break;
                case 'GORRAS Y CANGURERAS':
                    return [
                        'category_id' => 5,
                        'subcategory_id' => 27,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',GORRA,CAPUCHA,CANGURERA,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'PARAGUAS':
                    return [
                        'category_id' => 6,
                        'subcategory_id' => 32,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'PORTAFOLIOS':
                    return [
                        'category_id' => 5,
                        'subcategory_id' => 28,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',PORTAFOLIO,'.$producto['nombre_articulo']
                    ];
                    break;
                
                default:
                    return [
                        'category_id' => 5,
                        'subcategory_id' => 24,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',OTROS TEXTILES,'.$producto['nombre_articulo']
                    ];
                    break;
            }
            // --------- TEXTIL     
            //BOLSAS Y MORRALES
            //BOLSAS ECOLÓGICAS
            //MOCHILAS
            //MALETAS
            //LONCHERAS Y HIELERAS
            //GORRAS Y CANGURERAS
            //PARAGUAS
            //PORTAFOLIOS   
        }
        if($producto['categoria'] == "HERRAMIENTAS"){
            
            switch ($producto['sub_categoria']) {
                case 'ACCESORIOS PARA AUTO':
                    return [
                        'category_id' => 18,
                        'subcategory_id' => 90,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'HERRAMIENTAS':
                    $subcategoria = 33;
                    $string = '';
                    if(Str::contains($producto['descripcion'],"Flexómetro")){
                        $subcategoria = 36;
                        $string = 'FLEXOMETRO';
                    }
                    return [
                        'category_id' => 7,
                        'subcategory_id' => $subcategoria,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].','.$string
                    ];
                    break;
                case 'LÁMPARAS':
                    return [
                        'category_id' => 7,
                        'subcategory_id' => 34,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'NAVAJAS MULTIFUNCIÓN':
                    return [
                        'category_id' => 7,
                        'subcategory_id' => 35,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                
                default:
                    return [
                        'category_id' => 7,
                        'subcategory_id' => 33,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
            }
            // --------- HERRAMIENTAS   
            //ACCESORIOS PARA AUT
            //HERRAMIENTAS
            //LÁMPARAS
            //NAVAJAS MULTIFUNCIÓN   
        }

        if($producto['categoria'] == "ECOLOGICOS" || $producto['categoria'] == 'ECOLÓGICOS'){
            
            switch ($producto['sub_categoria']) {
                case 'LIBRETAS ECOLÓGICAS':
                    return [
                        'category_id' => 8,
                        'subcategory_id' => 38,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'NOTAS':
                    return [
                        'category_id' => 8,
                        'subcategory_id' => 39,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'BOLSAS ECOLÓGICAS':
                    return [
                        'category_id' => 8,
                        'subcategory_id' => 40,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;      
                
                default:
                    return [
                        'category_id' => 8,
                        'subcategory_id' => 41,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
            }
            // --------- ECOLOGICOS
            //LIBRETAS ECOLÓGICAS
            //NOTAS
            //BOLSAS ECOLÓGICAS  
        }

        if($producto['categoria'] == "HOGAR"){
            
            switch ($producto['sub_categoria']) {
                case 'COCINA':
                    $subcategoria = 42;
                    $string = '';
                    if(Str::contains($producto['descripcion'],"BBQ") || Str::contains($producto['descripcion'],"Asador")){
                        $subcategoria = 44;
                        $string = 'BBQ,ASADOR';
                    }
                    return [
                        'category_id' => 9,
                        'subcategory_id' => $subcategoria,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].','.$string
                    ];
                    break;
                case 'BAR':
                    return [
                        'category_id' => 9,
                        'subcategory_id' => 43,
                        'search' => $producto['categoria'].',BAR'.$producto['sub_categoria']
                    ];
                    break;
                case 'TAZAS':
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 74,
                        'search' => $producto['categoria'].',TAZA,TAZAS,'.$producto['sub_categoria']
                    ];
                    break;
                    
                default:
                    return [
                        'category_id' => 9,
                        'subcategory_id' => 45,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
            }
            // --------- HOGAR
            //COCINA
            //BAR
            //TAZAS 
        }

        if($producto['categoria'] == "OFICINA"){
            
            switch ($producto['sub_categoria']) {
                case 'ESCOLARES':
                    return [
                        'category_id' => 19,
                        'subcategory_id' => 92,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'ACCESORIOS DE OFICINA':
                    $subcategoria = 47;
                    $categoria = 10;
                    $string = '';
                    if(Str::contains($producto['descripcion'],"Calculadora")){
                        $subcategoria = 50;
                        $string = 'CALCULADORA';
                    }else if(Str::contains($producto['descripcion'],"portagafete")){
                        $subcategoria = 53;
                        $string = 'PORTAGAFETE,GAFETE';
                    }else if(Str::contains($producto['descripcion'],"Porta retrato")){
                        $categoria = 9;
                        $subcategoria = 46;
                        $string = 'RETRATO,PORTA RETRATO,PORTARETRATO';
                    }else if(Str::contains($producto['descripcion'],"Reloj")){
                        $categoria = 17;
                        $subcategoria = 87;
                        $string = 'RELOJ';
                    }else if(Str::contains($producto['descripcion'],"Tarjetero")){
                        $subcategoria = 52;
                        $string = 'TARJETA,TARJETERO';
                    }
                    
                    return [
                        'category_id' => $categoria,
                        'subcategory_id' => $subcategoria,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].','.$string
                    ];
                    break;
                case 'LIBRETAS':
                    return [
                        'category_id' => 10,
                        'subcategory_id' => 48,
                        'search' => $producto['categoria'].',LIBRETA,LIBRETAS,CUADERNO,CUADERNOS,'.$producto['sub_categoria']
                    ];
                    break;
                case 'CARPETAS':
                    return [
                        'category_id' => 10,
                        'subcategory_id' => 49,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;            
                default:
                    return [
                        'category_id' => 10,
                        'subcategory_id' => 47,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
            }
            // --------- OFICINA
            //ESCOLARES
            //ACCESORIOS DE OFICINA
            //LIBRETAS
            //CARPETAS  
        }

        if($producto['categoria'] == "TIEMPO LIBRE"){
            
            switch ($producto['sub_categoria']) {
                case 'VIAJE':
                    return [
                        'category_id' => 4,
                        'subcategory_id' => 20,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'ENTRETENIMIENTO':
                    return [
                        'category_id' => 11,
                        'subcategory_id' => 57,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'ANTIESTRÉS':
                    return [
                        'category_id' => 12,
                        'subcategory_id' => 59,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'MASCOTAS':
                    return [
                        'category_id' => 11,
                        'subcategory_id' => 58,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'DEPORTES':
                    return [
                        'category_id' => 11,
                        'subcategory_id' => 56,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                    
                default:
                    return [
                        'category_id' => 11,
                        'subcategory_id' => 57,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
            }
            // --------- TIEMPO LIBRE  
            //VIAJE
            //ENTRETENIMIENTO
            //ANTIESTRÉS
            //MASCOTAS
            //DEPORTES    
        }

        if($producto['categoria'] == "SUBLIMACIÓN"){
            
            switch ($producto['sub_categoria']) {
                case 'TAZAS':
                    return [
                        'category_id' => 13,
                        'subcategory_id' => 61,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'LIBRETAS':
                    return [
                        'category_id' => 13,
                        'subcategory_id' => 62,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'VASOS Y TARROS':
                    return [
                        'category_id' => 13,
                        'subcategory_id' => 63,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'TERMOS':
                    return [
                        'category_id' => 13,
                        'subcategory_id' => 64,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'CILINDROS METÁLICOS':
                    return [
                        'category_id' => 13,
                        'subcategory_id' => 65,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'ACCESORIOS DE OFICINA':
                    return [
                        'category_id' => 13,
                        'subcategory_id' => 66,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;     
                default:
                    return [
                        'category_id' => 13,
                        'subcategory_id' => 68,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
            }
            // --------- SUBLIMACIÓN
            //TAZAS
            //LIBRETAS
            //VASOS Y TARROS
            //TERMOS
            //CILINDROS METÁLICOS
            //ACCESORIOS DE OFICINA 
        }

        if($producto['categoria'] == "BEBIDAS"){
            
            switch ($producto['sub_categoria']) {
                case 'ÚNICA':
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 78,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'CILINDROS DE PLÁSTICO':
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 71,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',CILINDRO DE PLASTICO'
                    ];
                    break;
                case 'TAZAS':
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 74,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'TERMOS':
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 76,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'VASOS Y TARROS':
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 74,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                case 'CILINDROS METÁLICOS':
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 72,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',CILINDRO METALICO'
                    ];
                    break;
                case 'VASOS DE CARTÓN':
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 75,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
                default:
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 78,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
            }
            // --------- BEBIDAS
            //ÚNICA
            //CILINDROS DE PLÁSTICO
            //TAZAS
            //TERMOS
            //VASOS Y TARROS
            //CILINDROS METÁLICOS
        }

        if($producto['categoria'] == "LLAVEROS"){
            
            switch ($producto['sub_categoria']) {
                case 'LLAVEROS MULTIFUNCIONALES':
                    return [
                        'category_id' => 15,
                        'subcategory_id' => 79,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',LLAVERO MULTIFUNCIONAL'
                    ];
                    break;
                case 'LLAVEROS METÁLICOS':
                    $subcategoria = 80;
                    if(Str::contains($producto['descripcion'],"madera")){
                        $subcategoria = 83;
                    }
                    return [
                        'category_id' => 14,
                        'subcategory_id' => $subcategoria,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',LLAVERO METALICO'
                    ];
                    break;   
                default:
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 84,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
            }
            // --------- LLAVEROS  
            //LLAVEROS MULTIFUNCIONALES
            //LLAVEROS METÁLICOS        
        }

        if ($producto['categoria'] == 'HUICHOL') {
            switch ($producto['sub_categoria']) {
                case 'BOLÍGRAFOS METÁLICOS':
                    return [
                        'category_id' => 2,
                        'subcategory_id' => 7,
                        'search' => $producto['categoria'].','.$producto['sub_categoria'].',BOLIGRAFO METALICO,BOLIGRAFO DE METAL,'.$producto['nombre_articulo']
                    ];
                    break;
                case 'TERMOS':
                    return [
                        'category_id' => 13,
                        'subcategory_id' => 64,
                        'search' => $producto['categoria'].',TERMO,TERMOS,'.$producto['sub_categoria']
                    ];
                    break;
                case 'CILINDROS METÁLICOS':
                    return [
                        'category_id' => 13,
                        'subcategory_id' => 65,
                        'search' => $producto['categoria'].',CILINDROS,CILINDRO,CILINDRO METALICO,CILINDRO METÁLICO,CILINDROS METÁLICOS,'.$producto['sub_categoria']
                    ];
                    break;
                case 'BAR':
                    return [
                        'category_id' => 9,
                        'subcategory_id' => 43,
                        'search' => $producto['categoria'].',BAR'.$producto['sub_categoria']
                    ];
                    break;
                case 'LIBRETAS':
                    return [
                        'category_id' => 10,
                        'subcategory_id' => 48,
                        'search' => $producto['categoria'].',LIBRETA,LIBRETAS,CUADERNO,CUADERNOS,'.$producto['sub_categoria']
                    ];
                    break;
                case 'TAZAS':
                    return [
                        'category_id' => 14,
                        'subcategory_id' => 74,
                        'search' => $producto['categoria'].',TAZA,TAZAS,'.$producto['sub_categoria']
                    ];
                    break;

                default:
                    return [
                        'category_id' => 20,
                        'subcategory_id' => 93,
                        'search' => $producto['categoria'].','.$producto['sub_categoria']
                    ];
                    break;
            }
        }
    }
}
