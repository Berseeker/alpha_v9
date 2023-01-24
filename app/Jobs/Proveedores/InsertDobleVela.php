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

use App\Models\Product;
use App\Models\Logs;
use SoapClient;

class InsertDobleVela implements ShouldQueue
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
        $soapClient = new SoapClient('http://srv-datos.dyndns.info/doblevela/service.asmx?WSDL');
        $ObjectInfo = $soapClient->GetExistenciaAll(array("Key" => "jk3CttIRpY+iQT8m/i0uzQ=="));
        $result = json_decode($ObjectInfo->GetExistenciaAllResult, true);

        if ($result['intCodigo'] == 100) {
            $log = new Logs();
            $log->status = 'error';
            $log->message = 'Horario no permitido para hacer sync';
            $log->save();
        }

        $cont_new_products = 0; #Contador global
        $cont_update_products = 0; #Contador global
        foreach ($result['Resultado'] as $producto) {
            $product = Producto::where('parent_code', $producto['MODELO'])->first();
            if($product == null){
                $this->insertProduct($producto, $cont_new_products);
              
            }else{
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
        $log->message = 'Se agregaron '.$msg.' de DobleVela';
        $log->save();

        Log::info('Se agregaron '.$msg.' de DobleVela');
    }

    private function insertProduct($producto, &$cont_new_products){
  
        $item = new Product();
        $item->code = trim($producto['CLAVE']); //string
        $item->parent_code = trim($producto['MODELO']); //string
        $item->name = trim($producto['NOMBRE']);
        $item->details = trim($producto['Descripcion']);
        
        $item->images = null; //JSON
        $color = explode("-", $producto['COLOR']);
        $item->colors = json_encode(array(trim(Str::upper($color[1]))));
        $item->proveedor = 'DobleVela';
        $item->stock = $producto['EXISTENCIAS'];
        $item->box_pieces = (int) $producto['Unidad Empaque']; // int
        $item->nw = $producto['Peso caja']; //stirng
        $item->price = $producto['Price'];

        $metodo_x_impresion = [];
        if($producto['Tipo Impresion'] == "" || $producto['Tipo Impresion'] == null)
        {
            $metodo_x_impresion = null;
        }
        else {
            $tipo_impresiones = Str::of($producto['Tipo Impresion'])->explode(' ');
            foreach ($tipo_impresiones as $impresion) {

                switch($impresion)
                {
                    case 'SUB':
                        array_push($metodo_x_impresion, 'Sublimado');
                        break;

                    case 'BR':
                        array_push($metodo_x_impresion, 'Bordado');
                        break;

                    case 'FC':
                        array_push($metodo_x_impresion, "Full color");
                        break;

                    case 'TM':
                        array_push($metodo_x_impresion, "Tampografia");
                        break;

                    case 'GL':
                        array_push($metodo_x_impresion, "Grabado Laser");
                        break;

                    case 'SE':
                        array_push($metodo_x_impresion, "Serigrafia");
                        break;

                    case 'SB':
                        array_push($metodo_x_impresion, "SandBlast");
                        break;

                    case 'TR':
                        array_push($metodo_x_impresion, "Transfer");
                        break;

                    case 'GR':
                        array_push($metodo_x_impresion, "Gota de resina");
                        break;

                    case 'VT':
                        array_push($metodo_x_impresion, "Vitrificado");
                        break;

                    case 'HS':
                        array_push($metodo_x_impresion, "Hotstamping");
                        break;

                    default:
                        break;
                }
            }
        }
            
        $item->printing_methods = json_encode($metodo_x_impresion); // string
        $item->material = $producto['Material']; //string
        $item->custom = false;
        $item->category = $producto['Familia'];
        $item->subcategory = $producto['SubFamilia'];
            
        if($producto['Familia'] == 'TEXTILES')
        {
            $item->categoria_id = 5;
            $subcategoria = 93; //Subcategoria Varios

            if($producto['SubFamilia'] == 'GORRAS')
            {
                $subcategoria = 27;
                $item->search = $producto['Familia'].', TEXTÍL, '.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].', TEXTÍL, '.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            } 
            else if($producto['SubFamilia'] == 'MALETAS')
            {
                $subcategoria = 25;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'MALETINES')
            {
                $subcategoria = 29;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia']. ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'MOCHILAS'){
                $subcategoria = 25;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'PARAGUAS E IMPERMEABLES'){
                $item->categoria_id = 6;
                $subcategoria = 32;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'BOLSAS'){
                $subcategoria = 23;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'HIELERAS Y LONCHERAS'){
                $subcategoria = 26;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'CHALECOS'){
                $subcategoria = 30;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else{
                $subcategoria = 93;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }

            $item->subcategoria_id = $subcategoria;
        }
        else if($producto['Familia'] == 'BEBIDAS')
        {
            $subcategoria = 78; //Subcategoria Varios

            if($producto['SubFamilia'] == 'CILINDROS PLÁSTICOS'){
                $subcategoria = 71;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', CILÍNDROS, ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'TERMOS'){
                $subcategoria = 95;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', TÉRMOS, ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'TAZAS Y TARROS'){
                $subcategoria = 74;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'VASOS'){
                $subcategoria = 75;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'CILINDROS DE VIDRIO'){
                $subcategoria = 73;
                $item->search = $producto['Familia'] . ' , ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ' , ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'TAZAS Y TERMOS'){
                $subcategoria = 95;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else{
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
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
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', VIAJES, VACACIONES, ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS PARA VIAJE'){
                $subcategoria = 20;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'BRAZALETES'){
                $subcategoria = 21;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }else{
                $subcategoria = 93;
                $item->search = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'] . ', ' . $producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
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
                $item->search = $producto['Familia'].', RELOJ, RELÓJ, '.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].', RELOJ, RELÓJ,'.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'LIBRETAS'){
                $subcategoria = 48;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'PORTAGAFETES'){
                $subcategoria = 53;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS DE ESCRITORIO'){
                $subcategoria = 47;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'CALCULADORAS'){
                $subcategoria = 50;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'TARJETEROS'){
                $subcategoria = 52;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'ARTÍCULOS ESCOLARES'){
                $item->categoria_id = 19;
                $subcategoria = 92;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'MEMOS Y ADHESIVOS'){
                $subcategoria = 47;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'CARPETAS'){
                $subcategoria = 49;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'AGENDAS'){
                $subcategoria = 54;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'PORTA DOCUMENTOS'){
                $subcategoria = 51;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else{
                $subcategoria = 47;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }

            $item->subcategoria_id = $subcategoria;
        }
        else if($producto['Familia'] == 'HOGAR Y ESTILO DE VIDA')
        {
            $subcategoria = 93; //Subcategoria Varios
            $item->categoria_id = 9;

            if($producto['SubFamilia'] == 'ACCESORIOS DE COCINA'){
                $subcategoria = 42;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'BBQ'){
                $subcategoria = 44;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'MASCOTAS'){
                $item->categoria_id = 11;
                $subcategoria = 58;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'GOURMET'){
                $subcategoria = 42;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'ALCANCIAS'){
                $subcategoria = 45;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'PELUCHE'){
                $subcategoria = 45;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS PARA VINO'){
                $subcategoria = 45;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'INFANTIL'){
                $subcategoria = 45;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else{
                $subcategoria = 93;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }

            $item->subcategoria_id = $subcategoria;
            
        }
        else if($producto['Familia'] == 'ESCRITURA Y MÁS')
        {
            $subcategoria = 15; //Subcategoria Varios
            $item->categoria_id = 2;

            if($producto['SubFamilia'] == 'BOLÍGRAFOS PLÁSTICOS'){
                $subcategoria = 9;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'BOLÍGRAFOS ECOLÓGICOS'){
                $subcategoria = 10;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'BOLÍGRAFOS MULTIFUNCION'){
                $subcategoria = 8;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'SET DE BOLIGRAFOS'){
                $subcategoria = 12;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'BOLÍGRAFOS METÁLICOS'){
                $subcategoria = 7;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'LAPICES'){
                $subcategoria = 13;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'ESTUCHES DE REGALO'){
                $subcategoria = 11;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'CRAYOLAS'){
                $item->categoria_id = 19;
                $subcategoria = 92;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'BOLÍGRAFO RESALTADOR'){
                $subcategoria = 15;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else{
                $subcategoria = 15;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }

            $item->subcategoria_id = $subcategoria;   
        }
        else if($producto['Familia'] == 'TECNOLOGÍA')
        {
            $subcategoria = 6; //Subcategoria Varios

            if($producto['SubFamilia'] == 'AUDIFONOS Y BOCINAS'){
                $subcategoria = 1;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'USB'){
                $subcategoria = 3;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'BATERIAS'){
                $subcategoria = 6;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS DE CÓMPUTO'){
                $subcategoria = 4;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'CABLES Y CARGADORES'){
                $subcategoria = 5;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS CELULAR Y TABLET'){
                $subcategoria = 5;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else{
                $subcategoria = 6;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
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
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'LLAVEROS PLÁSTICOS'){
                $subcategoria = 81;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'LLAVEROS METÁLICOS'){
                $subcategoria = 80;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'FLEXOMETRO'){
                $item->categoria_id = 7;
                $subcategoria = 36;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'ACCESORIOS AUTO'){
                $item->categoria_id = 18;
                $subcategoria = 90;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'LINTERNAS'){
                $item->categoria_id = 7;
                $subcategoria = 33;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'LLAVEROS LUMINOSOS'){
                $subcategoria = 82;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'LLAVERO MADERA'){
                $subcategoria = 83;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else{
                $subcategoria = 84;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }

            $item->subcategoria_id = $subcategoria;   
        }
        else if($producto['Familia'] == 'SUBLIMACIÓN')
        {
            $subcategoria = 68; //Subcategoria Varios
            $item->categoria_id = 13;

            if($producto['SubFamilia'] == 'TAZAS Y TERMOS'){
                $subcategoria = 61;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'FUNDAS'){
                $subcategoria = 69;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'DECORATIVOS'){
                $subcategoria = 70;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else{
                $subcategoria = 68;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }

            $item->subcategoria_id = $subcategoria;   
        }
        else if($producto['Familia'] == 'SALUD Y BELLEZA')
        {
            $subcategoria = 19; //Subcategoria Varios
            $item->categoria_id = 3;

            if($producto['SubFamilia'] == 'CUIDADO PERSONAL'){
                $subcategoria = 19;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'BELLEZA'){
                $subcategoria = 17;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'SALUD'){
                $subcategoria = 16;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'ANTIESTRES'){
                $item->categoria_id = 12;
                $subcategoria = 59;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else if($producto['SubFamilia'] == 'COVID'){
                $subcategoria = 94;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else{
                $subcategoria = 19;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }

            $item->subcategoria_id = $subcategoria; 
        }
        else if($producto['Familia'] == 'NAYAD')
        {
            $subcategoria = 19; //Subcategoria Varios

            if($producto['SubFamilia'] == '- Ninguna Subfamilia -'){
                $item->categoria_id = 74;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }
            else{
                $subcategoria = 19;
                $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
                $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            }

            $item->categoria_id = 14;
            $item->subcategoria_id = $subcategoria;
            
        }
        else{
            $item->search = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            $item->meta_keywords = $producto['Familia'].','.$producto['SubFamilia'] . ', ' . Str::upper(trim($producto['NOMBRE']));
            $item->categoria_id = 20;
            $item->subcategoria_id = 93;  
        }
            
        $item->save();
        $cont_new_products++;
    }

    private function updateProduct($item, &$cont_update_products) {

        $product = Producto::where('parent_code', $item['MODELO'])->first();
        $colors = json_decode($product->colors);

        $item_color = explode("-", $item['COLOR']);;
        
        $pointer = false;
        foreach ($colors as $color) {

            if (trim(Str::upper($item_color[1])) === $color ) {
                $pointer = true;;
            }
        }

        if (!$pointer) {
            array_push($colors, trim(Str::upper($item_color[1])));
        }
        
      
        $product->colors = json_encode($colors);
        $product->save();

        $cont_update_products++;
    }
}
