<?php

namespace App\Http\Controllers\API\Proveedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;
//Para conexiones a la API
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
//Traer el modelo de Producto
use App\Models\Producto;

use Illuminate\Support\Str;

class forPromotionalController extends Controller
{
    public function index()
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


        //$products = $response->json();
        $count = 0;
        $update = 0;

        foreach ($response as $producto) 
        {


            $product = DB::table('productos')->where('SDK', '=', $producto['id_articulo'])->get();
            if(count($product) == 0){
                insertProduct($producto);
                $count ++;
            }else{
                if(count($product) > 1){
                    foreach ($product as $stuff) {
                        $stuff = Producto::find($product[0]->id);
                        $color = json_decode($stuff->color);
                        if(!in_array($producto['color'],$color))
                        {
                            array_push($color,$producto['color']);
                            $stuff->color = json_encode($color);
                            $stuff->save();
                        }
                        
                    }
                }else{
                    $item = Producto::find($product[0]->id);
                    $color = json_decode($item->color);
                    if(!in_array($producto['color'],$color))
                    {
                        array_push($color,$producto['color']);
                        $item->color = json_encode($color);
                        $item->save();
                    }
                }
                $update ++;
            }  
        }

        return response()->json([
            'status' => 'OK',
            'msg' => 'Se agregaron '.$count.' y se actualizaron '.$update.'productos de Forpromotional.'
        ]);


    }
}

function insertProduct($producto){

    try {   
        $product = new Producto;
        $product->SDK = $producto['id_articulo']; //string
        $product->nombre = $producto['nombre_articulo'];
        $product->nickname = $producto['nombre_articulo'];
        $product->descripcion = $producto['descripcion'];
        $images = array();
        foreach ($producto['imagenes'] as $img) 
        {
            $retach_img = "";
            $img_custom = explode('//',$img['url_imagen']);
            
            if($img_custom[0] == "https:"){
                $retach_img = $img_custom[0]."//".$img_custom[1];
            }else{
                $retach_img = "https://".$img_custom[1];
            }
            array_push($images,$retach_img);
        }
        //dd($images);
        $product->images = json_encode($images); //JSON
        $product->color = json_encode(array($producto['color'])); //JSON
        $product->proveedor = 'Forpromotional';
        $product->piezas_caja = $producto['piezas_caja']; // int
        $product->area_impresion = $producto['area_impresion']; //stirng
        $product->metodos_impresion = $producto['metodos_impresion']; // string
        $product->peso_caja = $producto['peso_caja']." kg"; //string -> se necesita agregar "KG"
        //Medidas en cm
        $product->medida_producto_ancho = $producto['medida_producto_ancho']." cm"; //string -> se necesita agregar "cm"
        $product->medida_producto_alto = $producto['medida_producto_alto']." cm"; //string -> se necesita agregar "cm"
        $product->medidas_producto_general = NULL;
        $product->alto_caja = $producto['alto_caja']; // int
        $product->ancho_caja = $producto['ancho_caja']; //int
        $product->largo_caja = $producto['largo_caja']; //int 
        $product->material = NULL; //string 
        $product->capacidad = NULL; //string 
        $product->caja_master = NULL; //string
        $product->modelo = $producto['id_articulo']; //string; //string
        if($producto['producto_promocion'] == "SI"){
            $product->promocion = 1; // 1 SIGNIFICA QUE ESTÁ EN PROMOCIÓN
        }else {
            $product->promocion = 0; //0 SIGNIFICA QUE NO ESTÁ EN PROMOCIÓN
        }


        if($producto['categoria'] == "TECNOLOGÍA"){
            
            switch ($producto['sub_categoria']) {
                case 'AUDÍFONOS':
                    $product->categoria_id = 1;
                    $product->subcategoria_id = 1;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'ÚNICA':
                    $product->categoria_id = 1;
                    $product->subcategoria_id = 6;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'BOCINAS':
                    $product->categoria_id = 1;
                    $product->subcategoria_id = 2;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'USB':
                    $product->categoria_id = 1;
                    $product->subcategoria_id = 3;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'ACCESORIOS Y CARGADORES':
                    $product->categoria_id = 1;
                    $product->subcategoria_id = 4;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'POWER BANKS':
                    $product->categoria_id = 1;
                    $product->subcategoria_id = 5;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                
                default:
                    $product->categoria_id = 1;
                    $product->subcategoria_id = 6;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
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
        if($producto['categoria'] == "BOLIGRAFOS"){
            
            switch ($producto['sub_categoria']) {
                case 'BOLÍGRAFOS METÁLICOS':
                    $product->categoria_id = 2;
                    $product->subcategoria_id = 7;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'BOLÍGRAFOS MULTIFUNCIONALES':
                    $product->categoria_id = 2;
                    $product->subcategoria_id = 8;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'BOLÍGRAFOS DE PLÁSTICO':
                    $product->categoria_id = 2;
                    $product->subcategoria_id = 9;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'BOLÍGRAFOS ECOLÓGICOS':
                    $product->categoria_id = 2;
                    $product->subcategoria_id = 10;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];

                    $ecologico = new Producto;
                    $ecologico->SDK = $producto['id_articulo']; //string
                    $ecologico->nombre = $producto['nombre_articulo'];
                    $ecologico->nickname = $producto['nombre_articulo'];
                    $ecologico->descripcion = $producto['descripcion'];
                    $images = array();
                    foreach ($producto['imagenes'] as $img) {
                        $retach_img = "";
                        $img_custom = explode('//',$img['url_imagen']);
                        
                        if($img_custom[0] == "https:"){
                            $retach_img = $img_custom[0]."//".$img_custom[1];
                        }else{
                            //$retach_img = "https://".$img_custom[1];
                            $retach_img = "http://".$img_custom[1];
                        }
                        array_push($images,$retach_img);
                        //array_push($images,$img['url_imagen']);
                    }
                    $ecologico->images = json_encode($images); //JSON
                    $ecologico->color = json_encode(array($producto['color'])); //JSON
                    $ecologico->proveedor = 'Forpromotional';
                    $ecologico->piezas_caja = $producto['piezas_caja']; // int
                    $ecologico->area_impresion = $producto['area_impresion']; //stirng
                    $ecologico->metodos_impresion = $producto['metodos_impresion']; // string
                    $ecologico->peso_caja = $producto['peso_caja']." kg"; //string -> se necesita agregar "KG"
                    //Medidas en cm
                    $ecologico->medida_producto_ancho = $producto['medida_producto_ancho']." cm"; //string -> se necesita agregar "cm"
                    $ecologico->medida_producto_alto = $producto['medida_producto_alto']." cm"; //string -> se necesita agregar "cm"
                    $ecologico->medidas_producto_general = NULL;
                    $ecologico->alto_caja = $producto['alto_caja']; // int
                    $ecologico->ancho_caja = $producto['ancho_caja']; //int
                    $ecologico->largo_caja = $producto['largo_caja']; //int 
                    $ecologico->material = NULL; //string 
                    $ecologico->capacidad = NULL; //string 
                    $ecologico->caja_master = NULL; //string
                    $ecologico->modelo = $producto['id_articulo']; //string
                    if($producto['producto_promocion'] == "SI"){
                        $ecologico->promocion = 1; // 1 SIGNIFICA QUE ESTÁ EN PROMOCIÓN
                    }else {
                        $ecologico->promocion = 0; //0 SIGNIFICA QUE NO ESTÁ EN PROMOCIÓN
                    }

                    $ecologico->categoria_id = 8;
                    $ecologico->subcategoria_id = 37;
                    $ecologico->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    $ecologico->save();

                    break;
                case 'BOLÍGRAFOS PLÁSTICO':
                    $product->categoria_id = 2;
                    $product->subcategoria_id = 9;
                    break;   
                default:
                    $product->categoria_id = 2;
                    $product->subcategoria_id = 15;
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
                    if(Str::contains($producto['descripcion'],"Cubre bocas") || Str::contains($producto['descripcion'],"Termómetro") || Str::contains($producto['descripcion'],"antibacterial") || Str::contains($producto['descripcion'],"Careta")){
                        $subcategoria = 94;
                    }
                    $product->categoria_id = 3;
                    $product->subcategoria_id = $subcategoria;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'BELLEZA':
                    $product->categoria_id = 3;
                    $product->subcategoria_id = 17;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'COSMETIQUERAS':
                    $product->categoria_id = 3;
                    $product->subcategoria_id = 18;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'CUIDADO PERSONAL':
                    $product->categoria_id = 3;
                    $product->subcategoria_id = 19;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'VIAJE':
                    $product->categoria_id = 4;
                    $product->subcategoria_id = 20;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                
                default:
                    $product->categoria_id = 3;
                    $product->subcategoria_id = 16;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
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
                    $product->categoria_id = 5;
                    $product->subcategoria_id = 22;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'BOLSAS ECOLÓGICAS':
                    $product->categoria_id = 5;
                    $product->subcategoria_id = 23;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];


                    $ecologico = new Producto;
                    $ecologico->SDK = $producto['id_articulo']; //string
                    $ecologico->nombre = $producto['nombre_articulo'];
                    $ecologico->nickname = $producto['nombre_articulo'];
                    $ecologico->descripcion = $producto['descripcion'];
                    
                    $images = array();
                    foreach ($producto['imagenes'] as $img) {
                        $retach_img = "";
                        $img_custom = explode('//',$img['url_imagen']);
                        
                        if($img_custom[0] == "https:"){
                            $retach_img = $img_custom[0]."//".$img_custom[1];
                        }else{
                            $retach_img = "https://".$img_custom[1];
                        }
                        array_push($images,$retach_img);
                        //array_push($images,$img['url_imagen']);
                    }
                    $ecologico->images = json_encode($images); //JSON
                    $ecologico->color = json_encode(array($producto['color'])); //JSON
                    $ecologico->proveedor = 'Forpromotional';
                    $ecologico->piezas_caja = $producto['piezas_caja']; // int
                    $ecologico->area_impresion = $producto['area_impresion']; //stirng
                    $ecologico->metodos_impresion = $producto['metodos_impresion']; // string
                    $ecologico->peso_caja = $producto['peso_caja']." kg"; //string -> se necesita agregar "KG"
                    //Medidas en cm
                    $ecologico->medida_producto_ancho = $producto['medida_producto_ancho']." cm"; //string -> se necesita agregar "cm"
                    $ecologico->medida_producto_alto = $producto['medida_producto_alto']." cm"; //string -> se necesita agregar "cm"
                    $ecologico->medidas_producto_general = NULL;
                    $ecologico->alto_caja = $producto['alto_caja']; // int
                    $ecologico->ancho_caja = $producto['ancho_caja']; //int
                    $ecologico->largo_caja = $producto['largo_caja']; //int 
                    $ecologico->material = NULL; //string 
                    $ecologico->capacidad = NULL; //string 
                    $ecologico->caja_master = NULL; //string
                    $ecologico->modelo = $producto['id_articulo']; //string
                    if($producto['producto_promocion'] == "SI"){
                        $ecologico->promocion = 1; // 1 SIGNIFICA QUE ESTÁ EN PROMOCIÓN
                    }else {
                        $ecologico->promocion = 0; //0 SIGNIFICA QUE NO ESTÁ EN PROMOCIÓN
                    }

                    $ecologico->categoria_id = 8;
                    $ecologico->subcategoria_id = 40;
                    $ecologico->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    $ecologico->save();
                    
                    break;
                case 'MOCHILAS':
                    $product->categoria_id = 5;
                    $product->subcategoria_id = 24;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'MALETAS':
                    $product->categoria_id = 5;
                    $product->subcategoria_id = 25;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'LONCHERAS Y HIELERAS':
                    $product->categoria_id = 5;
                    $product->subcategoria_id = 26;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'GORRAS Y CANGURERAS':
                    $product->categoria_id = 5;
                    $product->subcategoria_id = 27;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'PARAGUAS':
                    $product->categoria_id = 6;
                    $product->subcategoria_id = 32;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'PORTAFOLIOS':
                    $product->categoria_id = 5;
                    $product->subcategoria_id = 28;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                
                default:
                    $product->categoria_id = 5;
                    $product->subcategoria_id = 24;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
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
                    $product->categoria_id = 18;
                    $product->subcategoria_id = 90;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'HERRAMIENTAS':
                    $subcategoria = 33;
                    if(Str::contains($producto['descripcion'],"Flexómetro")){
                        $subcategoria = 36;
                    }
                    $product->categoria_id = 7;
                    $product->subcategoria_id = $subcategoria;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'LÁMPARAS':
                    $product->categoria_id = 7;
                    $product->subcategoria_id = 34;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'NAVAJAS MULTIFUNCIÓN':
                    $product->categoria_id = 7;
                    $product->subcategoria_id = 35;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                
                default:
                    $product->categoria_id = 7;
                    $product->subcategoria_id = 33;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
            }
            // --------- HERRAMIENTAS   
            //ACCESORIOS PARA AUT
            //HERRAMIENTAS
            //LÁMPARAS
            //NAVAJAS MULTIFUNCIÓN
            
        }
        if($producto['categoria'] == "ECOLOGICOS"){
            
            switch ($producto['sub_categoria']) {
                case 'LIBRETAS ECOLÓGICAS':
                    $product->categoria_id = 8;
                    $product->subcategoria_id = 38;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'NOTAS':
                    $product->categoria_id = 8;
                    $product->subcategoria_id = 39;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'BOLSAS ECOLÓGICAS':
                    $product->categoria_id = 8;
                    $product->subcategoria_id = 40;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;      
                
                default:
                    $product->categoria_id = 8;
                    $product->subcategoria_id = 41;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
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
                    if(Str::contains($producto['descripcion'],"BBQ") || Str::contains($producto['descripcion'],"Asador")){
                        $subcategoria = 44;
                    }
                    $product->categoria_id = 9;
                    $product->subcategoria_id = $subcategoria;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'BAR':
                    $product->categoria_id = 9;
                    $product->subcategoria_id = 43;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'TAZAS':
                    $product->categoria_id = 14;
                    $product->subcategoria_id = 74;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                    
                default:
                    $product->categoria_id = 9;
                    $product->subcategoria_id = 45;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
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
                    $product->categoria_id = 19;
                    $product->subcategoria_id = 92;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'ACCESORIOS DE OFICINA':
                    $subcategoria = 47;
                    $categoria = 10;
                    if(Str::contains($producto['descripcion'],"Calculadora")){
                        $subcategoria = 50;
                    }else if(Str::contains($producto['descripcion'],"portagafete")){
                        $subcategoria = 53;
                    }else if(Str::contains($producto['descripcion'],"Porta retrato")){
                        $categoria = 9;
                        $subcategoria = 46;
                    }else if(Str::contains($producto['descripcion'],"Reloj")){
                        $categoria = 17;
                        $subcategoria = 87;
                    }else if(Str::contains($producto['descripcion'],"Tarjetero")){
                        $subcategoria = 52;
                    }
                    $product->categoria_id = $categoria;
                    $product->subcategoria_id = $subcategoria;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'LIBRETAS':
                    $product->categoria_id = 10;
                    $product->subcategoria_id = 48;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'CARPETAS':
                    $product->categoria_id = 10;
                    $product->subcategoria_id = 49;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;            
                default:
                    $product->categoria_id = 10;
                    $product->subcategoria_id = 47;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
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
                    $product->categoria_id = 4;
                    $product->subcategoria_id = 20;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'ENTRETENIMIENTO':
                    $product->categoria_id = 11;
                    $product->subcategoria_id = 57;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'ANTIESTRÉS':
                    $product->categoria_id = 12;
                    $product->subcategoria_id = 59;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'MASCOTAS':
                    $product->categoria_id = 11;
                    $product->subcategoria_id = 58;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'DEPORTES':
                    $product->categoria_id = 11;
                    $product->subcategoria_id = 56;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                    
                default:
                    $product->categoria_id = 11;
                    $product->subcategoria_id = 57;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
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
                    $product->categoria_id = 13;
                    $product->subcategoria_id = 61;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'LIBRETAS':
                    $product->categoria_id = 13;
                    $product->subcategoria_id = 62;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'VASOS Y TARROS':
                    $product->categoria_id = 13;
                    $product->subcategoria_id = 63;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'TERMOS':
                    $product->categoria_id = 13;
                    $product->subcategoria_id = 64;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'CILINDROS METÁLICOS':
                    $product->categoria_id = 13;
                    $product->subcategoria_id = 65;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'ACCESORIOS DE OFICINA':
                    $product->categoria_id = 13;
                    $product->subcategoria_id = 66;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;     
                default:
                    $product->categoria_id = 13;
                    $product->subcategoria_id = 68;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
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
                    $product->categoria_id = 14;
                    $product->subcategoria_id = 78;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'CILINDROS DE PLÁSTICO':
                    $product->categoria_id = 14;
                    $product->subcategoria_id = 71;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'TAZAS':
                    $product->categoria_id = 14;
                    $product->subcategoria_id = 74;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'TERMOS':
                    $product->categoria_id = 14;
                    $product->subcategoria_id = 76;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'VASOS Y TARROS':
                    $product->categoria_id = 14;
                    $product->subcategoria_id = 74;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'CILINDROS METÁLICOS':
                    $product->categoria_id = 14;
                    $product->subcategoria_id = 72;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                default:
                    $product->categoria_id = 14;
                    $product->subcategoria_id = 78;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
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
                    $product->categoria_id = 15;
                    $product->subcategoria_id = 79;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
                case 'LLAVEROS METÁLICOS':
                    $subcategoria = 80;
                    if(Str::contains($producto['descripcion'],"madera")){
                        $subcategoria = 83;
                    }
                    $product->categoria_id = 14;
                    $product->subcategoria_id = $subcategoria;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;   
                default:
                    $product->categoria_id = 14;
                    $product->subcategoria_id = 84;
                    $product->busqueda = $producto['categoria'].','.$producto['sub_categoria'];
                    break;
            }
            // --------- LLAVEROS  
            //LLAVEROS MULTIFUNCIONALES
            //LLAVEROS METÁLICOS        
        }

        //Se guarda en la BD
        $product->save();
        
       // echo "<p style='color:green;'>El producto de agrego exitosamente con el id: ".$producto['id_articulo']." (Forpromotional)</p>";

    } catch (\Exception $e) {
        //print_r("<p style='color:red;'>El error fue: </p>".$e);
        return back()->with('fatal',"<p style='color:red;'>El error fue: </p>".$e);
    }

    
}
