<?php

namespace App\Http\Controllers\API\Proveedores;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

//Traer el modelo de Producto
use App\Models\Producto;

class InnovationController extends Controller
{
    public function index()
    {
        $global = array();
        //('/nusoap.php');
        $wsdl = "https://ws.innovation.com.mx/index.php?wsdl"; 
        $client = new \nusoap_client($wsdl, 'wsdl');
        $err = $client->getError();
        if ($err) 
        {
            //MOSTRAR ERRORES
            dd($err);
            exit();
        }
        //Formato de respuesta XML
        $params=array('user_api'=>'Pu7P5Qy602ea9d959f19Byo7','api_key'=>'76o602ea9d959f1f4awL8R-AzIa','format'=>'JSON');
        //Método para obtener  el número de páginas activas
        $pag=$client->call('Pages',$params);
        $pag = json_decode($pag,true);
        $page=1;
        //dd($pag);
        //condición para limitar el número de páginas a mostrar
        for ($i = 1; $pag <= $pag;$i++ ) 
        {

            //parámetros especificando la página
                $params=array('user_api'=>'Pu7P5Qy602ea9d959f19Byo7','api_key'=>'76o602ea9d959f1f4awL8R-AzIa','format'=>'JSON','page'=>$i);
                //Método para obtener información  de Productos
                $response=$client->call('Products',$params);
                $response=json_decode($response, true);
                if(!array_key_exists('data',$response))
                    dd($response);
                //dd($response);
                /****** TU CÓDIGO AQUÍ ******/
                // mostrar el resultado 
                foreach ($response['data'] as $key => $value) 
                {
                    $data = insertProductInnovation($value);
                    if(!in_array($data,$global))
                        array_push($global,$data);
                }
            
            /****** TU CÓDIGO AQUÍ ******/
        }
        //dd('normal');
        dd($global);


        return response()->json([
            'status' => 'success',
            'msg' => 'Se agregaron '.$count.' productos de Innovation '
        ]);

    }
}

function insertProductInnovation($producto){

    try {
       

            //array_push($global,$producto['categorias']['categorias'][0]['nombre']);
            //dd($global);
            return $producto['categorias']['categorias'][0]['nombre'];
       
        

    } catch (\Exception $e) {
        //print_r("El error fue: ".$e);
        return back()->with('fatal',"El error fue: ".$e);
    }

}