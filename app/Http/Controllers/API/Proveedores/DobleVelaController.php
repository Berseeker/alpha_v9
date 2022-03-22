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
            else if($producto['SubFamilia'] == 'MOCHILAS'){
                $subcategoria = 25;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else if($producto['SubFamilia'] == 'PARAGUAS E IMPERMEABLES'){
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
            }else{
                $subcategoria = 93;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->categoria_id = 5;
            $item->subcategoria_id = $subcategoria;
        }
        else if($producto['Familia'] == 'BEBIDAS')
        {
            $subcategoria = 93; //Subcategoria Varios

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
            else{
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
                $subcategoria = 93;
            }

            $item->categoria_id = 14;
            $item->subcategoria_id = $subcategoria;
        }

        else if($producto['Familia'] == 'VIAJE Y RECREACIÓN')
        {
            $subcategoria = 93; //Subcategoria Varios

            if($producto['SubFamilia'] == 'RECREACION'){
                $subcategoria = 20;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            else if($producto['SubFamilia'] == 'ACCESORIOS PARA VIAJE'){
                $subcategoria = 20;
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
            $subcategoria = 93; //Subcategoria Varios

            if($producto['SubFamilia'] == 'RELOJES'){
                $subcategoria = 87;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }else{
                $subcategoria = 93;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->categoria_id = 17;
            $item->subcategoria_id = $subcategoria;
        }
        else if($producto['Familia'] == 'HOGAR Y ESTILO DE VIDA')
        {
            $subcategoria = 93; //Subcategoria Varios

            if($producto['SubFamilia'] == 'ACCESORIOS DE COCINA'){
                $subcategoria = 42;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }
            else{
                $subcategoria = 93;
                $item->busqueda = $producto['Familia'].','.$producto['SubFamilia'];
            }

            $item->categoria_id = 9;
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
