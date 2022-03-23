<?php

namespace App\Http\Controllers\API\Proveedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use SoapClient;
//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;
//Para conexiones a la API
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
//Traer el modelo de Producto
use App\Models\Producto;
use App\Imports\UrlImport;


class DobleVelaController extends Controller
{
    protected $soapClient;

    public function __construct()
    {
        $this->soapClient = new SoapClient('http://srv-datos.dyndns.info/doblevela/service.asmx?WSDL');
    }

    public function index()
    {
        /* ------ INTEGRACION GRUPO VELA ------ */
        ini_set('max_execution_time', 6000); //600 seconds = 10 minutes
        /* ----- IMPLEMENTACION PARA CONSUMIR LA API ----- */
        $ObjectInfo = $this->soapClient->GetExistenciaAll(array("Key" => "jk3CttIRpY+iQT8m/i0uzQ=="));
        $result = json_decode($ObjectInfo->GetExistenciaAllResult, true);

        $count = 0;
        foreach ($result['Resultado'] as $producto) {
            $product = DB::table('productos')->where('modelo', '=', $producto['MODELO'])->get();
            if($product->isEmpty()){
                insertProductVela($producto);
                $count ++;
            }else{
                if(count($product) > 1){
                    foreach ($product as $stuff) {
                        $stuff = Producto::find($product[0]->id);
                        $color = json_decode($stuff->color);
                        $compare = explode("-", $producto['COLOR']);
                        if(!in_array($compare[1],$color))
                        {
                            array_push($color,$compare[1]);
                            $stuff->color = json_encode($color);
                            $stuff->save();
                        } 
                    }
                }else{
                    $item = Producto::find($product[0]->id);
                    $color = json_decode($item->color);
                    $compare = explode("-", $producto['COLOR']);
                    if(!in_array($compare[1],$color))
                    {
                        array_push($color,$compare[1]);
                        $item->color = json_encode($color);
                        $item->save();
                    }
                }
            }
        }

        return response()->json([
            'status' => 'OK',
            'msg' => 'Se agregaron '.$count.' productos nuevos de Grupo Vela.'
        ]);
        //return back()->with('alert','Se agregaron '.$count.' productos nuevos de Grupo Vela.');

    }

    public function update()
    {
        ini_set('max_execution_time', 9000); //600 seconds = 10 minutes
        $productos = Producto::where('proveedor','Doble Vela')->limit(300)->offset(400)->get();
        
        foreach ($productos as $producto) 
        {
            /* PROCESO DE OBTENCION DE IMAGENES */
            $ObjectInfo2 = $this->soapClient->GetrProdImagenes(array("Codigo" => '{"CLAVES": ["'.$producto->modelo.'"]}',"Key" => "jk3CttIRpY+iQT8m/i0uzQ=="));
            $result2 = json_decode($ObjectInfo2->GetrProdImagenesResult, true);
            $num = 0;
            $imgs = array();
            foreach($result2['Resultado']['MODELOS'] as $item)
            {
                foreach($item['encodedImage'] as $img_base64)
                {
                    if($num <= 2)
                    {
                        $image = str_replace('data:image/png;base64,', '', $img_base64);
                        $image = str_replace(' ', '+', $image);
                        $imageName = $producto->modelo.$num.'.png';

                        if (!Storage::disk('public')->exists($imageName)) 
                        {
                             Storage::disk('public')->put($imageName, base64_decode($image));
                            array_push($imgs,$imageName);
                            $num ++;
                        }
                    }
                }
            }
            
            if($producto->images == null)
            {
                if(empty($imgs)){
                    $imgs = null;
                }else{
                    $imgs = json_encode($imgs);
                }
            }
            else{
                $imgs = $producto->images;
            }
            /* FIN DE PROCESO DE OBTENCION DE IMAGENES */
            $producto->images = $imgs;
            $producto->save();
        }

        return response()->json([
            'status' => 'OK',
            'msg' => 'Se actualizaron las imagenes de los productos de Doble Vela'
        ]);
    }
}

function insertProductVela($producto){

    try {   

        $item = new Producto;
        $item->SDK = trim($producto['CLAVE']); //string
        $item->nombre = trim($producto['NOMBRE']);
        $item->nickname = trim($producto['Nombre Corto']);
        $item->descripcion = trim($producto['Descripcion']);
        
        $item->images = null; //JSON
        $color = explode("-", $producto['COLOR']);
        $item->color = json_encode(array(trim($color[1]))); //JSON
        $item->proveedor = 'Doble Vela';
        $item->piezas_caja = (int)$producto['Unidad Empaque']; // int
        $item->area_impresion = NULL; //stirng
        $item->metodos_impresion = NULL; // string
        $item->peso_caja = trim($producto['Peso caja']); //string -> ya incluye el KG
        //Medidas en cm
        $item->medida_producto_ancho = NULL; //string -> se necesita agregar "cm"
        $item->medida_producto_alto = NULL; //string -> se necesita agregar "cm"
        $item->medidas_producto_general = NULL;
        $item->alto_caja = NULL; // int
        $item->ancho_caja = NULL; //int
        $item->largo_caja = NULL; //int 
        $item->material = NULL; //string 
        $item->capacidad = NULL; //string 
        $item->caja_master = trim($producto['Medida Caja Master']); //string
        $item->modelo = trim($producto['MODELO']); //string
        $item->promocion = 0; //0 SIGNIFICA QUE NO ESTÁ EN PROMOCIÓN
        
        if($producto['Familia'] == 'TEXTILES')
        {
            //dd($product);
            $item->categoria_id = 5;
            $subcategoria = 93; //Subcategoria Varios

            if($producto['SubFamilia'] == 'GORRAS')
            {
                $subcategoria = 27;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            } 
            else if($producto['SubFamilia'] == 'MALETAS')
            {
                $subcategoria = 25;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'MALETINES')
            {
                $subcategoria = 29;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'MOCHILAS'){
                $subcategoria = 25;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'PARAGUAS E IMPERMEABLES'){
                $item->categoria_id = 6;
                $subcategoria = 32;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'BOLSAS'){
                $subcategoria = 23;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'HIELERAS Y LONCHERAS'){
                $subcategoria = 26;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'CHALECOS'){
                $subcategoria = 30;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $subcategoria = 93;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            
            $item->subcategoria_id = $subcategoria;
        }
        else if($producto['Familia'] == 'BEBIDAS')
        {
            $subcategoria = 78; //Subcategoria Varios

            if($producto['SubFamilia'] == 'CILINDROS PLÁSTICOS'){
                $subcategoria = 71;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'TERMOS'){
                $subcategoria = 95;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'TAZAS Y TARROS'){
                $subcategoria = 74;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'VASOS'){
                $subcategoria = 75;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'CILINDROS DE VIDRIO'){
                $subcategoria = 73;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'TAZAS Y TERMOS'){
                $subcategoria = 95;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
                $subcategoria = 78;
            }

            $item->categoria_id = 14;
            $item->subcategoria_id = $subcategoria;
        }

        else if($producto['Familia'] == 'VIAJE Y RECREACIÓN')
        {
            $subcategoria = 93; //Subcategoria Varios

            if($producto['SubFamilia'] == 'RECREACION'){
                $subcategoria = 96;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS PARA VIAJE'){
                $subcategoria = 20;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'BRAZALETES'){
                $subcategoria = 21;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }else{
                $subcategoria = 93;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->categoria_id = 4;
            $item->subcategoria_id = $subcategoria;
        }
        else if($producto['Familia'] == 'OFICINA')
        {
            $subcategoria = 47; //Subcategoria Varios
            $item->categoria_id = 10;

            if($producto['SubFamilia'] == 'RELOJES'){
                $subcategoria = 97;
                $item->categoria_id = 17;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'LIBRETAS'){
                $subcategoria = 48;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'PORTAGAFETES'){
                $subcategoria = 53;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS DE ESCRITORIO'){
                $subcategoria = 47;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'CALCULADORAS'){
                $subcategoria = 50;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'TARJETEROS'){
                $subcategoria = 52;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'ARTÍCULOS ESCOLARES'){
                $item->categoria_id = 19;
                $subcategoria = 92;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'MEMOS Y ADHESIVOS'){
                $subcategoria = 47;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'CARPETAS'){
                $subcategoria = 49;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'AGENDAS'){
                $subcategoria = 54;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'PORTA DOCUMENTOS'){
                $subcategoria = 51;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $subcategoria = 47;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->subcategoria_id = $subcategoria;
        }
        else if($producto['Familia'] == 'HOGAR Y ESTILO DE VIDA')
        {
            $subcategoria = 93; //Subcategoria Varios
            $item->categoria_id = 9;

            if($producto['SubFamilia'] == 'ACCESORIOS DE COCINA'){
                $subcategoria = 42;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'BBQ'){
                $subcategoria = 44;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'MASCOTAS'){
                $item->categoria_id = 11;
                $subcategoria = 58;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'GOURMET'){
                $subcategoria = 42;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'ALCANCIAS'){
                $subcategoria = 45;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'PELUCHE'){
                $subcategoria = 45;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS PARA VINO'){
                $subcategoria = 45;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'INFANTIL'){
                $subcategoria = 45;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $subcategoria = 93;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->subcategoria_id = $subcategoria;
            
        }
        else if($producto['Familia'] == 'ESCRITURA Y MÁS')
        {
            $subcategoria = 15; //Subcategoria Varios
            $item->categoria_id = 2;

            if($producto['SubFamilia'] == 'BOLÍGRAFOS PLÁSTICOS'){
                $subcategoria = 9;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'BOLÍGRAFOS ECOLÓGICOS'){
                $subcategoria = 10;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'BOLÍGRAFOS MULTIFUNCION'){
                $subcategoria = 8;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'SET DE BOLIGRAFOS'){
                $subcategoria = 12;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'BOLÍGRAFOS METÁLICOS'){
                $subcategoria = 7;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'LAPICES'){
                $subcategoria = 13;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'ESTUCHES DE REGALO'){
                $subcategoria = 11;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'CRAYOLAS'){
                $item->categoria_id = 19;
                $subcategoria = 92;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'BOLÍGRAFO RESALTADOR'){
                $subcategoria = 15;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $subcategoria = 15;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->subcategoria_id = $subcategoria;
            
        }
        else if($producto['Familia'] == 'TECNOLOGÍA')
        {
            $subcategoria = 6; //Subcategoria Varios

            if($producto['SubFamilia'] == 'AUDIFONOS Y BOCINAS'){
                $subcategoria = 1;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'USB'){
                $subcategoria = 3;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'BATERIAS'){
                $subcategoria = 6;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS DE CÓMPUTO'){
                $subcategoria = 4;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'CABLES Y CARGADORES'){
                $subcategoria = 5;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS CELULAR Y TABLET'){
                $subcategoria = 5;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $subcategoria = 6;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->categoria_id = 1;
            $item->subcategoria_id = $subcategoria;
            
        }
        else if($producto['Familia'] == 'LLAVEROS, LINTERNAS Y HERRAMIE')
        {
            $subcategoria = 84; //Subcategoria Varios
            $item->categoria_id = 15;

            if($producto['SubFamilia'] == 'HERRAMIENTAS'){
                $item->categoria_id = 7;
                $subcategoria = 33;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'LLAVEROS PLÁSTICOS'){
                $subcategoria = 81;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'LLAVEROS METÁLICOS'){
                $subcategoria = 80;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'FLEXOMETRO'){
                $item->categoria_id = 7;
                $subcategoria = 36;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS AUTO'){
                $item->categoria_id = 18;
                $subcategoria = 90;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'LINTERNAS'){
                $item->categoria_id = 7;
                $subcategoria = 33;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'LLAVEROS LUMINOSOS'){
                $subcategoria = 82;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'LLAVERO MADERA'){
                $subcategoria = 83;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $subcategoria = 84;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->subcategoria_id = $subcategoria;
            
        }
        else if($producto['Familia'] == 'SUBLIMACIÓN')
        {
            $subcategoria = 68; //Subcategoria Varios
            $item->categoria_id = 13;

            if($producto['SubFamilia'] == 'TAZAS Y TERMOS'){
                $item->categoria_id = 61;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'FUNDAS'){
                $item->categoria_id = 69;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'DECORATIVOS'){
                $item->categoria_id = 70;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $subcategoria = 68;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->subcategoria_id = $subcategoria;
            
        }
        else if($producto['Familia'] == 'SALUD Y BELLEZA')
        {
            $subcategoria = 19; //Subcategoria Varios
            $item->categoria_id = 3;

            if($producto['SubFamilia'] == 'CUIDADO PERSONAL'){
                $subcategoria = 19;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'BELLEZA'){
                $subcategoria = 17;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'SALUD'){
                $subcategoria = 16;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'ANTIESTRES'){
                $item->categoria_id = 12;
                $subcategoria = 59;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'COVID'){
                $subcategoria = 94;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $subcategoria = 19;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->subcategoria_id = $subcategoria;
            
        }
        else if($producto['Familia'] == 'NAYAD')
        {
            $subcategoria = 19; //Subcategoria Varios

            if($producto['SubFamilia'] == '- Ninguna Subfamilia -'){
                $item->categoria_id = 74;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $subcategoria = 19;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->categoria_id = 14;
            $item->subcategoria_id = $subcategoria;
            
        }
        else{
            $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            $item->categoria_id = 20;
            $item->subcategoria_id = 93;
            
        }
        //$item->categoria_id = 20; // Aqui se almacena el Id correspondiente a la categoria en la BD
        //$item->subcategoria_id = 93; // Aqui se alamacena el Id correspondiente a la subcategoria en la BD

        //Se guarda en la BD
        //dd($product);
        $item->save();

        //echo "<p style='color:green;'>El producto de agrego exitosamente con el id: ".$producto['CLAVE']." (Doble Vela)</p>";

    } catch (\Exception $e) {
        //print_r("El error fue: ".$e);
        return back()->with('fatal',"<p style='color:red;'>El error fue: </p>".$e);
    }
}
