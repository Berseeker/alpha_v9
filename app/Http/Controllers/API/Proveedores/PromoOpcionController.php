<?php

namespace App\Http\Controllers\API\Proveedores;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Producto;

class PromoOpcionController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'user' => 'GDL8043',
            'x-api-key' => 'e41f3d9771f94aa9c5e6edcc95d8e504'
        ])->post('https://www.contenidopromo.com/wsds/mx/catalogo/');

        $result = $response->json();

        if(array_key_exists('error',$result))
        {
            return response()->json([
                'status' => 'error',
                'msg' => $result['error'] 
            ]);
        }
        $count = 0;
        foreach ($result as $key => $item) 
        {
            $prevItem = Producto::where('SDK',$item['parent_code'])->where('proveedor','PromoOpcion')->first();
            if($prevItem == null)
            {
                insertProduct($item); 
                $count ++; 
            }
              
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Se agregaron '.$count.' productos de PromoOpcion de manera exitosa'
        ]);
    }
}


function insertProduct($producto)
{
    $product = new Producto();
    $product->nombre = $producto['name'];
    $product->nickname = $producto['name'];
    $product->SDK = $producto['parent_code'];
    $product->descripcion = $producto['description'];
    $product->images = json_encode(array($producto['img']));
    $product->color = json_encode(array($producto['color']));
    $product->proveedor = 'PromoOpcion';
    $product->piezas_caja = $producto['count_box'];
    $product->area_impresion = $producto['printing_area'];
    $impresion = '';
    if(Str::contains($producto['printing'], '/'))
    {
        $metodos = Str::of($producto['printing'])->explode('/');
        $count = 0;
        foreach ($metodos as $metodo) {
            if($count == 0)
            {
                $impresion = $impresion.trim($metodo); 
            }
            else {
                $impresion = $impresion.','.trim($metodo); 
            }
            $count++;
        }
    }else {
        $impresion = $producto['printing'];
    }
    $product->metodos_impresion = $impresion;
    $product->peso_caja = null;
    $product->medida_producto_ancho = null;
    $product->medida_producto_alto = null;
    $product->medidas_producto_general = $producto['size'];
    $product->alto_caja = ($producto['height'] == "") ? 0.0 : $producto['height'];
    $product->ancho_caja = ($producto['width'] == "") ? 0.0 : $producto['width'];
    $product->largo_caja = ($producto['length'] == "") ? 0.0 : $producto['length'];
    $product->caja_master = null;
    $product->modelo = $producto['item_code'];
    $product->material = $producto['material'];
    $product->capacidad = $producto['capacity'];
    $product->promocion = 0;
    $product->custom = 0;

    switch (Str::upper($producto['family'])) {
        case 'BAR':
            $product->categoria_id = 9; 
            $product->subcategoria_id = 43;
            $product->busqueda = 'HOGAR,BAR';
            break;
        case 'ARTICULOS DE OFICINA':
            if(Str::contains($producto['description'],"calculadora")){
                $product->subcategoria_id = 50;
                $product->categoria_id = 10;
                $product->busqueda = 'OFICINA,ARTICULOS DE OFICINA';
                break;
            }else if(Str::contains($producto['description'],"ecológico")){
                $product->subcategoria_id = 47;
                $product->categoria_id = 10;

                $product_T = new Producto;
                $product_T->SDK = $producto['parent_code']; //string
                $product_T->nombre = $producto['name'];
                $product_T->nickname = $producto['name'];
                $product_T->descripcion = $producto['description'];

                $product_T->images = json_encode(array($producto['img'])); //JSON

                $product_T->color = json_encode(array($producto['color']));

                
                $product_T->proveedor = 'PromoOpcion';
                $product_T->piezas_caja = (int)$producto['count_box']; // int
                $product_T->area_impresion = $producto['printing_area']; //stirng
                $product_T->metodos_impresion = $product->metodos_impresion; // string

                $product_T->peso_caja = $producto['nw']." kg"; //string -> se necesita agregar "KG"
                //Medidas en cm
                $product_T->medida_producto_ancho = NULL; //string -> se necesita agregar "cm"
                $product_T->medida_producto_alto = NULL; //string -> se necesita agregar "cm"
                
                $product_T->medidas_producto_general = $producto['size'];
                
            
                $product_T->alto_caja = $producto['height']; // int
                $product_T->ancho_caja = $producto['width']; //int
                $product_T->largo_caja = $producto['length']; //int 
                $product_T->material = $producto['material']; //string 
                $product_T->capacidad = $producto['capacity']; //string 
                $largo_caja = $producto['length'];
                $ancho_caja = $producto['width'];
                $altura_caja = $producto['height'];
                $caja_master = $largo_caja." x ".$ancho_caja." x ".$altura_caja." cm";
                $product_T->caja_master = $caja_master; //string
                $product_T->modelo = $producto['item_code']; //string
                $product_T->promocion = 0; //0 SIGNIFICA QUE NO ESTÁ EN PROMOCIÓN
                $product_T->subcategoria_id = 39;
                $product_T->categoria_id = 8;
                $product_T->existencias = null;
                $product_T->busqueda = 'ECOLOGICO,'.$producto['family'];
                $product_T->save();
                break;
            }else if(Str::contains($producto['description'],"tarjetero")){
                $product->subcategoria_id = 52;
                $product->categoria_id = 10;
                $product->busqueda = "OFICINA,TARJETERO";
                break;
            }else if(Str::contains($producto['description'],"portagafete")){
                $product->subcategoria_id = 53;
                $product->categoria_id = 10;
                $product->busqueda = "OFICINA,PORTAGAFETE";
                break;
            }
            else{
                $product->subcategoria_id = 47;
                $product->categoria_id = 10;
                $product->busqueda = "OFICINA,ARTICULOS DE OFICINA";
                break;
            }
        case 'ARTICULOS PARA VIAJE':
            $product->categoria_id = 4; 
            $product->subcategoria_id = 20;
            $product->busqueda = "VAIJE,ARTICULOS PARA VIAJE";
            break;
        case 'AGENDAS':
            $product->categoria_id = 10; 
            $product->subcategoria_id = 54;
            $product->busqueda = "OFICINA,AGENDAS";
            break;
        case 'CILINDRO DE PLASTICO':
            $product->categoria_id = 14; 
            $product->subcategoria_id = 71;
            $product->busqueda = "BEBIDAS,CILINDRO DE PLASTICO";
            break;
        case 'ACC SMARTPH Y TABLET':
            $product->categoria_id = 1; 
            $product->subcategoria_id = 5;
            $product->busqueda = "TECNOLOGIA,ACCESORIOS DE CELULAR";
            break;
        case 'AUDIO':

            if(Str::contains($producto['description'],"Bocina") || Str::contains($producto['description'],"bocina")){
                $product->subcategoria_id = 2;
                $product->categoria_id = 1;
                $product->busqueda = "TECNOLOGIA,BOCINA";
                break;
            }else{
                $product->subcategoria_id = 1;
                $product->categoria_id = 1;
                $product->busqueda = "TECNOLOGIA,OTROS TECNOLOGIA";
                break;
            }
        case 'HOGAR':
            if(Str::contains($producto['description'],"asador") || Str::contains($producto['description'],"bbq")){
                $product->subcategoria_id = 44;
                $product->categoria_id = 9;
                $product->busqueda = "HOGAR,ASADOR";
                break;
            }else if(Str::contains($producto['description'],"mandil") || Str::contains($producto['description'],"cubiertos") || Str::contains($producto['description'],"guante") || Str::contains($producto['description'],"agarradera chop")){
                $product->subcategoria_id = 42;
                $product->categoria_id = 9;
                $product->busqueda = "HOGAR,MANDIL";
                break;
            }else if(Str::contains($producto['description'],"set bilbao") || Str::contains($producto['description'],"utensilios meran") || Str::contains($producto['description'],"cuchillos corvi")){
                $product->subcategoria_id = 42;
                $product->categoria_id = 9;
                $product->busqueda = "HOGAR,UTENCILIOS";
                break;
            }else{
                $product->subcategoria_id = 45;
                $product->categoria_id = 9;
                $product->busqueda = "HOGAR,OTROS HOGAR";
                break;
            }
        case 'ACC COMPUTO':
            $product->categoria_id = 1; 
            $product->subcategoria_id = 4;
            $product->busqueda = "TECNOLOGIA,ACCESORIOS COMPUTO";
            break;
        case 'GORRAS Y SOMBREROS':
            $product->categoria_id = 5; 
            $product->subcategoria_id = 27;
            $product->busqueda = "HOGAR,OTROS HOGAR";
            break;
        case 'CHAMARRAS Y CHALECOS':
            $product->categoria_id = 5; 
            $product->subcategoria_id = 30;
            $product->busqueda = "TEXTIL,CHAMARRAS Y CHALECOS";
            break;
        case 'DEPORTES':
            $product->categoria_id = 11; 
            $product->subcategoria_id = 56;
            $product->busqueda = "TIEMPO LIBRE,DEPORTES";
            break;
        case 'LIBRETAS':
            $product->categoria_id = 10; 
            $product->subcategoria_id = 48;
            $product->busqueda = "OFICINA,LIBRETAS";
            break;
        case 'BELLEZA':
            if(Str::contains($producto['description'],"cosmetiquera")){
                $product->subcategoria_id = 18;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,BELLEZA";
                break;
            }else if(Str::contains($producto['description'],"manicure") || Str::contains($producto['description'],"costurero") || Str::contains($producto['description'],"kit de baño") || Str::contains($producto['description'],"cepillo")){
                $product->subcategoria_id = 19;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,CUIDADO PERSONAL";
                break;
            }else if(Str::contains($producto['description'],"repelente") || Str::contains($producto['description'],"antifaz") || Str::contains($producto['description'],"bascula") || Str::contains($producto['description'],"cinta masa")){
                $product->subcategoria_id = 19;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,ARTICULOS CONTINGENCIA";
                break;
            }else if(Str::contains($producto['description'],"espejo") || Str::contains($producto['description'],"brochas")){
                $product->subcategoria_id = 17;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,BELLEZA";
                break;
            }else if(Str::contains($producto['description'],"gel") || Str::contains($producto['description'],"kit antibacterial") || Str::contains($producto['description'],"toallitas") || Str::contains($producto['description'],"antibacterial")){
                $product->subcategoria_id = 94;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,ARTICULOS CONTINGENCIA";
                break;
            }
            else if(Str::contains($producto['description'],"careta") || Str::contains($producto['description'],"cubrebocas")){
                $product->subcategoria_id = 94;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,ARTICULOS CONTINGENCIA";
                break;
            }else if(Str::contains($producto['description'],"mentas") || Str::contains($producto['description'],"pastillero" || Str::contains($producto['description'],"notas"))){
                $product->subcategoria_id = 16;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,CUIDADO PERSONAL";
                break;
            }else{
                $product->subcategoria_id = 16;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,SALUD";
                break;
            }
        case 'LLAVEROS FUNCIONES':
            $product->categoria_id = 15; 
            $product->subcategoria_id = 79;
            $product->busqueda = "LLAVEROS,LLAVEROS MULTIFUNCION";
            break;
        case 'NIÑOS':
            if(Str::contains($producto['description'],"regla") || Str::contains($producto['description'],"borrador")){
                $product->subcategoria_id = 92;
                $product->categoria_id = 19;
                $product->busqueda = "KIDS Y ESCOLARES,BELLEZA";
                break;
            }else if(Str::contains($producto['description'],"colores") || Str::contains($producto['description'],"crayones")){
                $product->subcategoria_id = 92;
                $product->categoria_id = 19;
                $product->busqueda = "KIDS Y ESCOLARES,CRAYONES";
                break;
            }else if(Str::contains($producto['description'],"geometría") || Str::contains($producto['description'],"estuche") || Str::contains($producto['description'],"escolar")){
                $product->subcategoria_id = 92;
                $product->categoria_id = 19;
                $product->busqueda = "KIDS Y ESCOLARES,GEOMETRIA";
                break;
            }else{
                $product->subcategoria_id = 91;
                $product->categoria_id = 19;
                $product->busqueda = "KIDS Y ESCOLARES,BELLEZA";
                break;
            }
        case 'BOLIGRAFOS FUNCIONES':
            if(Str::contains($producto['description'],"set")){
                $product->subcategoria_id = 12;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS MULTIFUNCION,SET DE BOLIGRAFOS";
                break;
            }else if(Str::contains($producto['description'],"usb")){
                $product->subcategoria_id = 8;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS MULTIFUNCION,BOLIGRAFO USB";
                break;
            }else if(Str::contains($producto['description'],"estuche")){
                $product->subcategoria_id = 11;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS MULTIFUNCION,ESTUCHE BOLIGRAFO";
                break;
            }else if(Str::contains($producto['description'],"plastico")){
                $product->subcategoria_id = 9;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO";
                break;
            }else if(Str::contains($producto['material'],"aleación cobre") || Str::contains($producto['material'],"acero inoxidable" )|| Str::contains($producto['material'],"aluminio")){
                $product->subcategoria_id = 7;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO METALICO,BOLIGRAFO DE METAL";
                break;
            }else if(Str::contains($producto['material'],"metal") || Str::contains($producto['material'],"aleación cobre") || Str::contains($producto['material'],"aleación Cobre")){
                $product->subcategoria_id = 7;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO METALICO,BOLIGRAFO DE METAL";
                break;
            }else if(Str::contains($producto['material'],"acero inoxidable")){
                $product->subcategoria_id = 7;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO METALICO,BOLIGRAFO DE METAL";
                break;
            }else{
                $product->subcategoria_id = 15;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO METALICO";
                break;
            }
        case 'BOLIGRAFOS PLASTICO':

            if(Str::contains($producto['material'],"Cartón / Plástico") || Str::contains($producto['material'],"Cartón / Plástico / Trigo") || Str::contains($producto['material'],"Plástico / Bambú / Trigo")){
                $product->subcategoria_id = 10;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO";
                $product_T = new Producto;
                $product_T->SDK = $producto['parent_code']; //string
                $product_T->nombre = $producto['name'];
                $product_T->nickname = $producto['name'];
                $product_T->descripcion = $producto['description'];
                $product_T->images = json_encode(array($producto['img'])); //JSON
                $product_T->color = json_encode(array($producto['color']));        
                $product_T->proveedor = 'PromoOpcion';
                $product_T->piezas_caja = (int)$producto['count_box']; // int
                $product_T->area_impresion = $producto['printing_area']; //stirng
                $product_T->metodos_impresion = $product->metodos_impresion; // string
                $product_T->peso_caja = $producto['nw']." kg"; //string -> se necesita agregar "KG"
                $product_T->medida_producto_ancho = NULL; //string -> se necesita agregar "cm"
                $product_T->medida_producto_alto = NULL; //string -> se necesita agregar "cm"
                $product_T->medidas_producto_general = $producto['size'];
                $product_T->alto_caja = NULL; // int
                $product_T->ancho_caja = NULL; //int
                $product_T->largo_caja = NULL; //int 
                $product_T->material = $producto['material']; //string 
                $product_T->capacidad = $producto['capacity']; //string 
                $largo_caja = $producto['length'];
                $ancho_caja = $producto['width'];
                $altura_caja = $producto['height'];
                $caja_master = $largo_caja." x ".$ancho_caja." x ".$altura_caja." cm";
                $product_T->caja_master = $caja_master; //string
                $product_T->modelo = $producto['item_code']; //string
                $product_T->promocion = 0; //0 SIGNIFICA QUE NO ESTÁ EN PROMOCIÓN
                $product_T->subcategoria_id = 37;
                $product_T->categoria_id = 8;
                $product_T->existencias = null;
                $product_T->busqueda = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO";
                $product_T->save();

                break;
            }else if(Str::contains($producto['description'],"set")){
                $product->subcategoria_id = 12;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO PLASTICO,SET DE BOLIGRAFOS";
                break;
            }else if(Str::contains($producto['description'],"usb")){
                $product->subcategoria_id = 8;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO PLASTICO,BOLIGRAFO CON USB";
                break;
            }else if(Str::contains($producto['description'],"estuche")){
                $product->subcategoria_id = 11;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO PLASTICO,ESTUCHE DE BOLIGRAFOS";
                break;
            }else if(Str::contains($producto['description'],"plastico")){
                $product->subcategoria_id = 9;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO";
                break;
            }else if(Str::contains($producto['material'],"aleación cobre") || Str::contains($producto['material'],"acero inoxidable" )|| Str::contains($producto['material'],"aluminio")){
                $product->subcategoria_id = 7;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO PLASTICO,SET DE BOLIGRAFOS";
                break;
            }else if(Str::contains($producto['material'],"metal") || Str::contains($producto['material'],"aleación cobre / fibra de carbono") || Str::contains($producto['material'],"aleación cobre / aluminio")){
                $product->subcategoria_id = 7;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO METALICO,BOLIGRAGO DE METAL";
                break;
            }else if(Str::contains($producto['material'],"acero Inoxidable / curpiel")){
                $product->subcategoria_id = 7;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO METALICO,BOLIGRAGO DE METAL";
                break;
            }else{
                $product->subcategoria_id = 15;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFO METALICO";
                break;
            }
        case 'HERRAMIENTAS':
            if(Str::contains($producto['description'],"flexometro") || Str::contains($producto['description'],"medidor")){
                $product->subcategoria_id = 36;
                $product->categoria_id = 7;
                $product->busqueda = "HERRAMIENTAS,FLEXOMETRO";
                break;
            }else if(Str::contains($producto['description'],"lampara")){
                $product->subcategoria_id = 34;
                $product->categoria_id = 7;
                $product->busqueda = "HERRAMIENTAS,LAMPARA";
                break;
            }else if(Str::contains($producto['description'],"navaja")){
                $product->subcategoria_id = 35;
                $product->categoria_id = 7;
                $product->busqueda = "HERRAMIENTAS,NAVAJA";
                break;
            }else{
                $product->subcategoria_id = 33;
                $product->categoria_id = 7;
                $product->busqueda = "HERRAMIENTAS";
                break;
            }
        case 'SALUD':
            if(Str::contains($producto['description'],"cosmetiquera")){
                $product->subcategoria_id = 18;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,COSMETIQUERA";
                break;
            }else if(Str::contains($producto['description'],"manicure") || Str::contains($producto['description'],"costurero") || Str::contains($producto['description'],"kit de baño") || Str::contains($producto['description'],"cepillo")){
                $product->subcategoria_id = 19;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,MANICURE";
                break;
            }else if(Str::contains($producto['description'],"repelente") || Str::contains($producto['description'],"antifaz") || Str::contains($producto['description'],"bascula") || Str::contains($producto['description'],"cinta masa")){
                $product->subcategoria_id = 19;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,ANTIFAZ";
                break;
            }else if(Str::contains($producto['description'],"espejo") || Str::contains($producto['description'],"brochas")){
                $product->subcategoria_id = 17;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,ESPEJO - BROCHAS";
                break;
            }else if(Str::contains($producto['description'],"gel") || Str::contains($producto['description'],"kit antibacterial") || Str::contains($producto['description'],"toallitas") || Str::contains($producto['description'],"antibacterial")){
                $product->subcategoria_id = 94;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,ARTICULOS DE CONTINGENCIA";
                break;
            }
            else if(Str::contains($producto['description'],"careta") || Str::contains($producto['description'],"cubrebocas")){
                $product->subcategoria_id = 94;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,ARTICULOS DE CONTINGENCIA";
                break;
            }else if(Str::contains($producto['description'],"mentas") || Str::contains($producto['description'],"pastillero" || Str::contains($producto['description'],"notas"))){
                $product->subcategoria_id = 16;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL,PASTILLERO";
                break;
            }else{
                $product->subcategoria_id = 16;
                $product->categoria_id = 3;
                $product->busqueda = "SALUD Y CUIDADO PERSONAL";
                break;
            }
        case 'PARAGUAS':
            $product->categoria_id = 6; 
            $product->subcategoria_id = 32;
            $product->busqueda = "PARAGUAS";
            break;
        case 'ENTRETENIMIENTO':
            $product->categoria_id = 11; 
            $product->subcategoria_id = 57;
            $product->busqueda = "ENTRETENIMIENTO";
            break;
        case 'LLAVEROS METALICOS':
            $product->categoria_id =15; 
            $product->subcategoria_id = 80;
            $product->busqueda = "LLAVEROS,LLAVEROS METALICOS";
            break;
        case 'HIELERAS Y LONCHERAS':
            $product->categoria_id = 5; 
            $product->subcategoria_id = 26;
            $product->busqueda = "TEXTIL,HIELERAS Y LONCHERAS";
            break;
        case 'PORTAFOLIOS':
            $product->categoria_id = 5; 
            $product->subcategoria_id = 28;
            $product->busqueda = "TEXTIL,PORTAFOLIOS";
            break;
        case 'IMPULSA':
            //se elimina
            
            break;
        case 'LLAVEROS DE PLASTICO':
            $product->categoria_id = 15; 
            $product->subcategoria_id = 81;
            $product->busqueda = "LLAVEROS,LLAVEROS DE PLASTICO";
            break;
        case 'CARPETAS':
            $product->categoria_id = 10; 
            $product->subcategoria_id = 49;
            $product->busqueda = "OFICINA,CARPETAS";
            break;
        case 'RELOJES':
            $product->categoria_id = 17; 
            $product->subcategoria_id = 87;
            $product->busqueda = "RELOJ,RELOJES";
            break;
        case 'MASCOTAS':
            $product->categoria_id = 11; 
            $product->subcategoria_id = 58;
            $product->busqueda = "TIEMPO LIBRE,MASCOTAS";
            break;
        case 'PLAYERAS':
            $product->categoria_id = 5; 
            $product->subcategoria_id = 31;
            $product->busqueda = "TEXTIL,PLAYERAS";
            break;
        case 'PORTARRETRATOS':
            $product->categoria_id = 9; 
            $product->subcategoria_id = 46;
            $product->busqueda = "HOGAR,PORTARETRATOS";
            break;
        case 'MOCHILAS':
            $product->categoria_id = 5; 
            $product->subcategoria_id = 24;
            $product->busqueda = "TEXTIL,MOCHILA";
            break;
        case 'BOLSAS':
            $product->categoria_id = 5; 
            $product->subcategoria_id = 22;
            $product->busqueda = "TEXTIL,BOLSA";
            break;
        case 'MALETAS':
            $product->categoria_id = 5; 
            $product->subcategoria_id = 25;
            $product->busqueda = "TEXTIL,MALETAS";
            break;
        case 'ANTI-STRESS':
            $product->categoria_id = 12; 
            $product->subcategoria_id = 59;
            $product->busqueda = "ANTIESTRESS";
            break;
        case 'TERMO DE PLASTICO':
            if(Str::contains($producto['description'],"VASO")){
                $product->subcategoria_id = 75;
                $product->categoria_id = 14;
                $product->busqueda = "BEBIDAS,VASOS";
                break;
            }else if(Str::contains($producto['description'],"TARRO")){
                $product->subcategoria_id = 74;
                $product->categoria_id = 14;
                $product->busqueda = "BEBIDAS,TAZAS Y TARROS";
                break;
            }else{
                $product->subcategoria_id = 76;
                $product->categoria_id = 14;
                $product->busqueda = "BEBIDAS,TERMOS DE PLASTICO";
                break;
            }
        case 'TAZAS':
            $product->categoria_id = 14; 
            $product->subcategoria_id = 74;
            $product->busqueda = "BEBIDAS,TAZAS Y TARROS";
            break;
        case 'CILINDROS METALICOS':
            $product->categoria_id = 14; 
            $product->subcategoria_id = 72;
            $product->busqueda = "BEBIDAS,CILINDROS METALICOS";
            break;
        case 'TERMO METALICO':
            $product->categoria_id = 14; 
            $product->subcategoria_id = 77;
            $product->busqueda = "BEBIDAS,TERMO METALICO";
            break;
        case 'USB':
            $product->categoria_id = 1; 
            $product->subcategoria_id = 3;
            $product->busqueda = "TECNOLOGIA,USB";
            break;
        case 'BOLIGRAFOS METALICOS':
            if(Str::contains($producto['material'],"Cartón / Plástico") || Str::contains($producto['material'],"Cartón / Plástico / Trigo") || Str::contains($producto['material'],"Plástico / Bambú / Trigo")){
                $product->subcategoria_id = 10;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS,BOLIGRAFOS ECOLOGICOS";
                $product_T->SDK = $producto['parent_code']; //string
                $product_T->nombre = $producto['name'];
                $product_T->nickname = $producto['name'];
                $product_T->descripcion = $producto['description'];
                $product_T->images = json_encode(array($producto['img'] )); //JSON
                $product_T->color = json_encode(array($producto['color']));        
                $product_T->proveedor = 'PromoOpcion';
                $product_T->piezas_caja = (int)$producto['count_box']; // int
                $product_T->area_impresion = $producto['printing_area']; //stirng
                $product_T->metodos_impresion = $product->metodos_impresion; // string
                $product_T->peso_caja = $producto['nw']." kg"; //string -> se necesita agregar "KG"
                $product_T->medida_producto_ancho = NULL; //string -> se necesita agregar "cm"
                $product_T->medida_producto_alto = NULL; //string -> se necesita agregar "cm"
                $product_T->medidas_producto_general = $producto['size'];
                $product_T->alto_caja = NULL; // int
                $product_T->ancho_caja = NULL; //int
                $product_T->largo_caja = NULL; //int 
                $product_T->material = $producto['material']; //string 
                $product_T->capacidad = $producto['capacity']; //string 
                $largo_caja = $producto['length'];
                $ancho_caja = $producto['width'];
                $altura_caja = $producto['height'];
                $caja_master = $largo_caja." x ".$ancho_caja." x ".$altura_caja." cm";
                $product_T->caja_master = $caja_master; //string
                $product_T->modelo = $producto['item_code']; //string
                $product_T->promocion = 0; //0 SIGNIFICA QUE NO ESTÁ EN PROMOCIÓN
                $product_T->existencias = null;
                $product_T->busqueda = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO";
                $product_T->subcategoria_id = 37;
                $product_T->categoria_id = 8;
                $product_T->save();
                break;
            }else if(Str::contains($producto['description'],"marcatextos")){
                $product->subcategoria_id = 55;
                $product->categoria_id = 10;
                $product->busqueda = "OFICINA,MARCA TEXTOS";
                break;
            }else if(Str::contains($producto['description'],"set")){
                $product->subcategoria_id = 12;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS,SET DE BOLIGRAFOS";
                break;
            }else if(Str::contains($producto['description'],"usb")){
                $product->subcategoria_id = 8;
                $product->categoria_id = 2;
                $product->busqueda = "TECNOLOGIA,USB";
                break;
            }else if(Str::contains($producto['description'],"ESTUCHE")){
                $product->subcategoria_id = 11;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS,ESTUCHES DE REGALO";
                break;
            }else if(Str::contains($producto['material'],"plástico")){
                $product->subcategoria_id = 9;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS,BOLIGRAFO DE PLASTICO";
                break;
            }else if(Str::contains($producto['material'],"Aleación Cobre") || Str::contains($producto['material'],"Acero Inoxidable" )|| Str::contains($producto['material'],"Aluminio")){
                $product->subcategoria_id = 7;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS,BOLIGRAGO METALICO";
                break;
            }else if(Str::contains($producto['material'],"Metal") || Str::contains($producto['material'],"Aleación Cobre / Fibra de Carbono") || Str::contains($producto['material'],"Aleación Cobre / Aluminio")){
                $product->subcategoria_id = 7;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS,BOLIGRAFO METALICO";
                break;
            }else if(Str::contains($producto['material'],"Acero Inoxidable / Curpiel")){
                $product->subcategoria_id = 7;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS,BOLIGRAFO METALICO";
                break;
            }else{
                $product->subcategoria_id = 15;
                $product->categoria_id = 2;
                $product->busqueda = "BOLIGRAFOS,OTROS BOLIGRAFOS";
                break;
            }
        
        default:
            $product->categoria_id = 20; 
            $product->subcategoria_id = 93;
            $product->busqueda = "OTROS,VARIOS";
            break;
    }

    $product->existencias = 0;
    $product->save();


}