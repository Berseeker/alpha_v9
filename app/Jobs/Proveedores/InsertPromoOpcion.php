<?php

namespace App\Jobs\Proveedores;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Logs;

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
        } else {

            $cont_new_products = 0; #Contador global
            foreach ($result as $key => $item) 
            {
                $prevItem = Product::where('code',$item['parent_code'])->where('proveedor','PromoOpcion')->first();
                if($prevItem == null)
                {
                    $this->insertProduct($item, $cont_new_products); 
                }   
            }

            $msg = '';
            if ($cont_new_products > 0) {
                $msg = $msg.$cont_new_products. ' productos nuevos';
            }

            $log = new Logs();
            $log->status = 'Error';
            $log->message = $msg . 'en PromoOpcion.';
            $log->save();
            Log::error($msg . 'en PromoOpcion.');
        }   
    }

    private function insertProduct($item, &$cont_new_products)
    {
        $product = new Product();
        $product->name = $item['name'];
        $product->code = $item['item_code'];
        $product->parent_code = $item['parent_code'];
        $colors = explode('/', $item['colors']);
        
        $colors = [];
        foreach ($colors as $color) {
            if ($color == 'a') {
                array_push($colors, 'azul');
            } else if ($color == 'r') {
                array_push($colors, 'rojo');
            } else if ($color == 'v') {
                array_push($colors, 'verde');
            } else if ($color == 'be') {
                array_push($colors, 'beige');
            } else if ($color == 'c') {
                array_push($colors, 'cafe');
            } else if ($color == 'n') {
                array_push($colors, 'negro');
            } else if ($color == 't') {
                array_push($colors, 'tinto');
            } else if ($color == 'ac') {
                array_push($colors, 'azul cielo');
            } else {
                array_push($colors, $color);
            }
        }

        $product->colors = json_encode($colors);
        $product->details = $item['description'];
        $product->nw = $item['nw'] . ' kg';
        $product->gw = $item['gw'] . ' kg';
        $product->medida_producto_alto = $item['height'];
        $product->medida_producto_ancho = $item['width'];
        $product->printing_area = $item['printing_area'];
        $printing = [];
        $metodos_impresion = explode('/', $item['printing']);
        foreach ($metodos_impresion as $impresion) {
            array_push($printing, trim($impresion));
        }
        $product->printing_methods = json_encode($printing);
        $product->category = $item['family'];
        $product->box_pieces = $item['count_box'];
        $product->capacity = $item['capacity'];
        $product->material = $item['material'];
        $product->custom = false;
        $product->proveedor = 'PromoOpcion';
        $product->images = json_encode(array($item['img'])); //JSON

        switch (Str::upper($item['family'])) {
            case 'BAR':
                $product->categoria_id = 9; 
                $product->subcategoria_id = 43;
                $product->search = 'HOGAR, BAR, CASA, ' . Str::upper($item['name']);
                $product->meta_keywords = 'HOGAR, BAR, CASA, ' . Str::upper($item['name']);
                break;
            case 'ARTICULOS DE OFICINA':
                if(Str::contains($item['description'],"calculadora")){
                    $product->subcategoria_id = 50;
                    $product->categoria_id = 10;
                    $product->search = 'OFICINA, ARTICULOS DE OFICINA, TRABAJO, ' . Str::upper($item['name']);
                    $product->meta_keywords = 'OFICINA, ARTICULOS DE OFICINA, TRABAJO, ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"ecológico")){
                    $product->subcategoria_id = 47;
                    $product->categoria_id = 10;
                    $product->search = 'ECOLOGICO, ECOLÓGICO, ECOLOGÍA, ECOLÓGICA, '. $item['family']. ', ' . Str::upper($item['name']);
                    $product->meta_keywords = 'ECOLOGICO, ECOLÓGICO, ECOLOGÍA, ECOLÓGICA, '. $item['family']. ', ' . Str::upper($item['name']);

                    $product_T = new Product();
                    $product_T->code = $item['item_code']; //string
                    $product_T->name = $item['name'];
                    $product_T->parent_code = $item['parent_code'];
                    $product_T->details = $item['description'];
                    $product_T->images = json_encode(array($item['img'])); //JSON
                    $product_T->colors = json_encode($colors);
                    $product_T->proveedor = 'PromoOpcion';
                    $product_T->box_pieces = (int)$item['count_box']; // int
                    $product_T->printing_area = $item['printing_area']; //stirng
                    $product_T->printing_methods = json_encode($printing); // string
                    $product_T->nw = $item['nw']." kg"; //string -> se necesita agregar "KG"
                    $product_T->gw = $item['gw']." kg"; //string -> se necesita agregar "KG"
                    $product_T->medida_producto_alto = $item['height']; // int
                    $product_T->medida_producto_ancho = $item['width']; //int
                    $product_T->material = $item['material']; //string 
                    $product_T->capacity = $item['capacity']; //string
                    $product_T->category = $item['family'];
                    $product_T->custom = false;
                    $product_T->subcategoria_id = 39;
                    $product_T->categoria_id = 8;
                    $product_T->search = 'ECOLOGICO, ECOLÓGICO, ECOLOGÍA, ECOLÓGICA, '. $item['family']. ', ' . Str::upper($item['name']);
                    $product_T->meta_keywords = 'ECOLOGICO, ECOLÓGICO, ECOLOGÍA, ECOLÓGICA, '. $item['family']. ', ' . Str::upper($item['name']);
                    $product_T->save();
                    break;
                }else if(Str::contains($item['description'],"tarjetero")){
                    $product->subcategoria_id = 52;
                    $product->categoria_id = 10;
                    $product->search = "OFICINA, TARJETERO, TARJETA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "OFICINA, TARJETERO, TARJETA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"portagafete")){
                    $product->subcategoria_id = 53;
                    $product->categoria_id = 10;
                    $product->search = "OFICINA, PORTAGAFETE, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "OFICINA, PORTAGAFETE, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
                else{
                    $product->subcategoria_id = 47;
                    $product->categoria_id = 10;
                    $product->search = "OFICINA,ARTICULOS DE OFICINA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "OFICINA,ARTICULOS DE OFICINA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            case 'ARTICULOS PARA VIAJE':
                $product->categoria_id = 4; 
                $product->subcategoria_id = 20;
                $product->search = "VIAJE, VACACIONES, RELAX, ARTICULOS PARA VIAJE, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "VIAJE, VACACIONES, RELAX, ARTICULOS PARA VIAJE, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'AGENDAS':
                $product->categoria_id = 10; 
                $product->subcategoria_id = 54;
                $product->search = "OFICINA, AGENDAS, TRABAJO, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "OFICINA, AGENDAS, TRABAJO, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'CILINDRO DE PLASTICO':
                $product->categoria_id = 14; 
                $product->subcategoria_id = 71;
                $product->search = "BEBIDAS,CILINDRO DE PLASTICO, CILÍNDROS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "BEBIDAS,CILINDRO DE PLASTICO, CILÍNDROS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'ACC SMARTPH Y TABLET':
                $product->categoria_id = 1; 
                $product->subcategoria_id = 5;
                $product->search = "TECNOLOGIA ,ACCESORIOS DE CELULAR, TECNOLOGÍA, SMARTPHONE, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TECNOLOGIA ,ACCESORIOS DE CELULAR, TECNOLOGÍA, SMARTPHONE, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'AUDIO':

                if(Str::contains($item['description'],"Bocina") || Str::contains($item['description'],"bocina")){
                    $product->subcategoria_id = 2;
                    $product->categoria_id = 1;
                    $product->search = "TECNOLOGIA, BOCINA, MÚSICA, MUSICA, TECNOLOGÍA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "TECNOLOGIA, BOCINA, MÚSICA, MUSICA, TECNOLOGÍA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else{
                    $product->subcategoria_id = 1;
                    $product->categoria_id = 1;
                    $product->search = "TECNOLOGIA, TECNOLOGÍA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "TECNOLOGIA, TECNOLOGÍA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            case 'HOGAR':
                if(Str::contains($item['description'],"asador") || Str::contains($item['description'],"bbq")){
                    $product->subcategoria_id = 44;
                    $product->categoria_id = 9;
                    $product->search = "HOGAR, ASADOR ,BBQ, CASA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "HOGAR, ASADOR ,BBQ, CASA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"mandil") || Str::contains($item['description'],"cubiertos") || Str::contains($item['description'],"guante") || Str::contains($item['description'],"agarradera chop")){
                    $product->subcategoria_id = 42;
                    $product->categoria_id = 9;
                    $product->search = "HOGAR, CASA, MANDIL, CUBIERTOS, CASA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "HOGAR, CASA, MANDIL, CUBIERTOS, CASA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"set bilbao") || Str::contains($item['description'],"utensilios meran") || Str::contains($item['description'],"cuchillos corvi")){
                    $product->subcategoria_id = 42;
                    $product->categoria_id = 9;
                    $product->search = "HOGAR, UTENCILIOS, CASA, CUBIERTOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "HOGAR, UTENCILIOS, CASA, CUBIERTOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else{
                    $product->subcategoria_id = 45;
                    $product->categoria_id = 9;
                    $product->search = "HOGAR, CASA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "HOGAR, CASA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            case 'ACC COMPUTO':
                $product->categoria_id = 1; 
                $product->subcategoria_id = 4;
                $product->search = "TECNOLOGIA,ACCESORIOS COMPUTO, COMPUTADORAS, PC, TECNOLOGÍA, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TECNOLOGIA,ACCESORIOS COMPUTO, COMPUTADORAS, PC, TECNOLOGÍA, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'GORRAS Y SOMBREROS':
                $product->categoria_id = 5; 
                $product->subcategoria_id = 27;
                $product->search = "HOGAR, CASA, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "HOGAR, CASA, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'CHAMARRAS Y CHALECOS':
                $product->categoria_id = 5; 
                $product->subcategoria_id = 30;
                $product->search = "TEXTIL,CHAMARRAS Y CHALECOS, TEXTÍL, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TEXTIL,CHAMARRAS Y CHALECOS, TEXTÍL, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'DEPORTES':
                $product->categoria_id = 11; 
                $product->subcategoria_id = 56;
                $product->search = "TIEMPO LIBRE, DEPORTES, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TIEMPO LIBRE, DEPORTES, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'LIBRETAS':
                $product->categoria_id = 10; 
                $product->subcategoria_id = 48;
                $product->search = "OFICINA, LIBRETAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "OFICINA, LIBRETAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'BELLEZA':
                if(Str::contains($item['description'],"cosmetiquera")){
                    $product->subcategoria_id = 18;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL, BELLEZA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL, BELLEZA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"manicure") || Str::contains($item['description'],"costurero") || Str::contains($item['description'],"kit de baño") || Str::contains($item['description'],"cepillo")){
                    $product->subcategoria_id = 19;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL, CUIDADO PERSONAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL, CUIDADO PERSONAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"repelente") || Str::contains($item['description'],"antifaz") || Str::contains($item['description'],"bascula") || Str::contains($item['description'],"cinta masa")){
                    $product->subcategoria_id = 19;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL, ARTICULOS CONTINGENCIA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL, ARTICULOS CONTINGENCIA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"espejo") || Str::contains($item['description'],"brochas")){
                    $product->subcategoria_id = 17;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL, BELLEZA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL, BELLEZA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"gel") || Str::contains($item['description'],"kit antibacterial") || Str::contains($item['description'],"toallitas") || Str::contains($item['description'],"antibacterial")){
                    $product->subcategoria_id = 94;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL, ARTICULOS CONTINGENCIA, GEL, SANITIZANTE, KIT ANTIBACTERIAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL, ARTICULOS CONTINGENCIA, GEL, SANITIZANTE, KIT ANTIBACTERIAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
                else if(Str::contains($item['description'],"careta") || Str::contains($item['description'],"cubrebocas")){
                    $product->subcategoria_id = 94;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL, ARTICULOS CONTINGENCIA, CARETA, CUBREBOCAS, TAPABOCAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL, ARTICULOS CONTINGENCIA, CARETA, CUBREBOCAS, TAPABOCAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"mentas") || Str::contains($item['description'],"pastillero" || Str::contains($item['description'],"notas"))){
                    $product->subcategoria_id = 16;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL, CUIDADO PERSONAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL, CUIDADO PERSONAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else{
                    $product->subcategoria_id = 16;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL, SALUD, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL, SALUD, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            case 'LLAVEROS FUNCIONES':
                $product->categoria_id = 15; 
                $product->subcategoria_id = 79;
                $product->search = "LLAVEROS,LLAVEROS MULTIFUNCION, LLAVÉROS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "LLAVEROS,LLAVEROS MULTIFUNCION, LLAVÉROS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'NIÑOS':
                if(Str::contains($item['description'],"regla") || Str::contains($item['description'],"borrador")){
                    $product->subcategoria_id = 92;
                    $product->categoria_id = 19;
                    $product->search = "KIDS Y ESCOLARES,BELLEZA, UTILES ESCOLAES, ESCUELA, TAREA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "KIDS Y ESCOLARES,BELLEZA, UTILES ESCOLAES, ESCUELA, TAREA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"colores") || Str::contains($item['description'],"crayones")){
                    $product->subcategoria_id = 92;
                    $product->categoria_id = 19;
                    $product->search = "KIDS Y ESCOLARES,CRAYONES, COLORES, ESCUELA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "KIDS Y ESCOLARES,CRAYONES, COLORES, ESCUELA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"geometría") || Str::contains($item['description'],"estuche") || Str::contains($item['description'],"escolar")){
                    $product->subcategoria_id = 92;
                    $product->categoria_id = 19;
                    $product->search = "KIDS Y ESCOLARES,GEOMETRIA, ESCUELA, TAREA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "KIDS Y ESCOLARES,GEOMETRIA, ESCUELA, TAREA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else{
                    $product->subcategoria_id = 91;
                    $product->categoria_id = 19;
                    $product->search = "KIDS Y ESCOLARES, BELLEZA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "KIDS Y ESCOLARES, BELLEZA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            case 'BOLIGRAFOS FUNCIONES':
                if(Str::contains($item['description'],"set")){
                    $product->subcategoria_id = 12;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS MULTIFUNCION,SET DE BOLIGRAFOS, REGALOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS MULTIFUNCION,SET DE BOLIGRAFOS, REGALOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"usb")){
                    $product->subcategoria_id = 8;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS MULTIFUNCION, BOLIGRAFO USB, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS MULTIFUNCION, BOLIGRAFO USB, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"estuche")){
                    $product->subcategoria_id = 11;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS MULTIFUNCION,ESTUCHE BOLIGRAFO, BOLÍGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS MULTIFUNCION,ESTUCHE BOLIGRAFO, BOLÍGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"plastico")){
                    $product->subcategoria_id = 9;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS PLASTICO,BOLÍGRAFOS, PLÁSTICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS PLASTICO,BOLÍGRAFOS, PLÁSTICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['material'],"aleación cobre") || Str::contains($item['material'],"acero inoxidable" )|| Str::contains($item['material'],"aluminio")){
                    $product->subcategoria_id = 7;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO METALICO, BOLÍGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO METALICO, BOLÍGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['material'],"metal") || Str::contains($item['material'],"aleación cobre") || Str::contains($item['material'],"aleación Cobre")){
                    $product->subcategoria_id = 7;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO METALICO, BOLÍGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO METALICO, BOLÍGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['material'],"acero inoxidable")){
                    $product->subcategoria_id = 7;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO METALICO,BOLÍGRAFOS, METAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO METALICO,BOLÍGRAFOS, METAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else{
                    $product->subcategoria_id = 15;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS, METALICO, BOLÍGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS, METALICO, BOLÍGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            case 'BOLIGRAFOS PLASTICO':

                if(Str::contains($item['material'],"Cartón / Plástico") || Str::contains($item['material'],"Cartón / Plástico / Trigo") || Str::contains($item['material'],"Plástico / Bambú / Trigo")){
                    $product->subcategoria_id = 10;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS DE PLASTICO,BOLÍGRAFOS DE PLASTICO" . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS DE PLASTICO,BOLÍGRAFOS DE PLASTICO" . $item['family'] . ', ' . Str::upper($item['name']);

                    $product_T = new Product();
                    $product_T->code = $item['item_code']; //string
                    $product_T->name = $item['name'];
                    $product_T->parent_code = $item['parent_code'];
                    $product_T->details = $item['description'];
                    $product_T->images = json_encode(array($item['img'])); //JSON
                    $product_T->colors = json_encode($colors);
                    $product_T->proveedor = 'PromoOpcion';
                    $product_T->box_pieces = (int)$item['count_box']; // int
                    $product_T->printing_area = $item['printing_area']; //stirng
                    $product_T->printing_methods = json_encode($printing); // string
                    $product_T->nw = $item['nw']." kg"; //string -> se necesita agregar "KG"
                    $product_T->gw = $item['gw']." kg"; //string -> se necesita agregar "KG"
                    $product_T->medida_producto_alto = $item['height']; // int
                    $product_T->medida_producto_ancho = $item['width']; //int
                    $product_T->material = $item['material']; //string 
                    $product_T->capacity = $item['capacity']; //string
                    $product_T->category = $item['family'];
                    $product_T->custom = false;
                    $product_T->subcategoria_id = 37;
                    $product_T->categoria_id = 8;
                    $product_T->search = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO, ECOLÓGICOS, ECOLOGÍA, ECOLÓGICA, RECICLABLE, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product_T->meta_keywords = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO, ECOLÓGICOS, ECOLOGÍA, ECOLÓGICA, RECICLABLE, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product_T->save();

                    break;
                }else if(Str::contains($item['description'],"set")){
                    $product->subcategoria_id = 12;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO PLASTICO,SET DE BOLIGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO PLASTICO,SET DE BOLIGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"usb")){
                    $product->subcategoria_id = 8;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO PLASTICO,BOLIGRAFO CON USB, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO PLASTICO,BOLIGRAFO CON USB, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"estuche")){
                    $product->subcategoria_id = 11;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO PLASTICO,ESTUCHE DE BOLIGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO PLASTICO,ESTUCHE DE BOLIGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"plastico")){
                    $product->subcategoria_id = 9;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['material'],"aleación cobre") || Str::contains($item['material'],"acero inoxidable" )|| Str::contains($item['material'],"aluminio")){
                    $product->subcategoria_id = 7;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO PLASTICO,SET DE BOLIGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO PLASTICO,SET DE BOLIGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['material'],"metal") || Str::contains($item['material'],"aleación cobre / fibra de carbono") || Str::contains($item['material'],"aleación cobre / aluminio")){
                    $product->subcategoria_id = 7;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO METALICO,BOLIGRAGO DE METAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO METALICO,BOLIGRAGO DE METAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['material'],"acero Inoxidable / curpiel")){
                    $product->subcategoria_id = 7;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO METALICO,BOLIGRAGO DE METAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO METALICO,BOLIGRAGO DE METAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else{
                    $product->subcategoria_id = 15;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFO METALICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFO METALICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            case 'HERRAMIENTAS':
                if(Str::contains($item['description'],"flexometro") || Str::contains($item['description'],"medidor")){
                    $product->subcategoria_id = 36;
                    $product->categoria_id = 7;
                    $product->search = "HERRAMIENTAS,FLEXOMETRO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "HERRAMIENTAS,FLEXOMETRO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"lampara")){
                    $product->subcategoria_id = 34;
                    $product->categoria_id = 7;
                    $product->search = "HERRAMIENTAS,LAMPARA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "HERRAMIENTAS,LAMPARA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"navaja")){
                    $product->subcategoria_id = 35;
                    $product->categoria_id = 7;
                    $product->search = "HERRAMIENTAS,NAVAJA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "HERRAMIENTAS,NAVAJA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else{
                    $product->subcategoria_id = 33;
                    $product->categoria_id = 7;
                    $product->search = "HERRAMIENTAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "HERRAMIENTAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            case 'SALUD':
                if(Str::contains($item['description'],"cosmetiquera")){
                    $product->subcategoria_id = 18;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL,COSMETIQUERA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL,COSMETIQUERA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"manicure") || Str::contains($item['description'],"costurero") || Str::contains($item['description'],"kit de baño") || Str::contains($item['description'],"cepillo")){
                    $product->subcategoria_id = 19;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL,MANICURE, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL,MANICURE, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"repelente") || Str::contains($item['description'],"antifaz") || Str::contains($item['description'],"bascula") || Str::contains($item['description'],"cinta masa")){
                    $product->subcategoria_id = 19;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL,ANTIFAZ, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL,ANTIFAZ, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"espejo") || Str::contains($item['description'],"brochas")){
                    $product->subcategoria_id = 17;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL,ESPEJO - BROCHAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL,ESPEJO - BROCHAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"gel") || Str::contains($item['description'],"kit antibacterial") || Str::contains($item['description'],"toallitas") || Str::contains($item['description'],"antibacterial")){
                    $product->subcategoria_id = 94;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL,ARTICULOS DE CONTINGENCIA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL,ARTICULOS DE CONTINGENCIA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
                else if(Str::contains($item['description'],"careta") || Str::contains($item['description'],"cubrebocas")){
                    $product->subcategoria_id = 94;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL,ARTICULOS DE CONTINGENCIA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL,ARTICULOS DE CONTINGENCIA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"mentas") || Str::contains($item['description'],"pastillero" || Str::contains($item['description'],"notas"))){
                    $product->subcategoria_id = 16;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL,PASTILLERO, ". $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL,PASTILLERO, ". $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else{
                    $product->subcategoria_id = 16;
                    $product->categoria_id = 3;
                    $product->search = "SALUD Y CUIDADO PERSONAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "SALUD Y CUIDADO PERSONAL, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            case 'PARAGUAS':
                $product->categoria_id = 6; 
                $product->subcategoria_id = 32;
                $product->search = "PARAGUAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "PARAGUAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'ENTRETENIMIENTO':
                $product->categoria_id = 11; 
                $product->subcategoria_id = 57;
                $product->search = "ENTRETENIMIENTO, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "ENTRETENIMIENTO, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'LLAVEROS METALICOS':
                $product->categoria_id =15; 
                $product->subcategoria_id = 80;
                $product->search = "LLAVEROS,LLAVEROS METALICOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "LLAVEROS,LLAVEROS METALICOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'HIELERAS Y LONCHERAS':
                $product->categoria_id = 5; 
                $product->subcategoria_id = 26;
                $product->search = "TEXTIL,HIELERAS Y LONCHERAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TEXTIL,HIELERAS Y LONCHERAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'PORTAFOLIOS':
                $product->categoria_id = 5; 
                $product->subcategoria_id = 28;
                $product->search = "TEXTIL,PORTAFOLIOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TEXTIL,PORTAFOLIOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'IMPULSA':
                //se elimina
                
                break;
            case 'LLAVEROS DE PLASTICO':
                $product->categoria_id = 15; 
                $product->subcategoria_id = 81;
                $product->search = "LLAVEROS,LLAVEROS DE PLASTICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "LLAVEROS,LLAVEROS DE PLASTICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'CARPETAS':
                $product->categoria_id = 10; 
                $product->subcategoria_id = 49;
                $product->search = "OFICINA,CARPETAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "OFICINA,CARPETAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'RELOJES':
                $product->categoria_id = 17; 
                $product->subcategoria_id = 87;
                $product->search = "RELOJ,RELOJES, RELÓJES, ". $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "RELOJ,RELOJES, RELÓJES, ". $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'MASCOTAS':
                $product->categoria_id = 11; 
                $product->subcategoria_id = 58;
                $product->search = "TIEMPO LIBRE,MASCOTAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TIEMPO LIBRE,MASCOTAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'PLAYERAS':
                $product->categoria_id = 5; 
                $product->subcategoria_id = 31;
                $product->search = "TEXTIL,PLAYERAS, TEXTÍL, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TEXTIL,PLAYERAS, TEXTÍL, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'PORTARRETRATOS':
                $product->categoria_id = 9; 
                $product->subcategoria_id = 46;
                $product->search = "HOGAR,PORTARETRATOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "HOGAR,PORTARETRATOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'MOCHILAS':
                $product->categoria_id = 5; 
                $product->subcategoria_id = 24;
                $product->search = "TEXTIL,MOCHILA, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TEXTIL,MOCHILA, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'BOLSAS':
                $product->categoria_id = 5; 
                $product->subcategoria_id = 22;
                $product->search = "TEXTIL,BOLSA, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TEXTIL,BOLSA, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'MALETAS':
                $product->categoria_id = 5; 
                $product->subcategoria_id = 25;
                $product->search = "TEXTIL,MALETAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TEXTIL,MALETAS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'ANTI-STRESS':
                $product->categoria_id = 12; 
                $product->subcategoria_id = 59;
                $product->search = "ANTIESTRESS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "ANTIESTRESS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'TERMO DE PLASTICO':
                if(Str::contains($item['description'],"VASO")){
                    $product->subcategoria_id = 75;
                    $product->categoria_id = 14;
                    $product->search = "BEBIDAS,VASOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BEBIDAS,VASOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"TARRO")){
                    $product->subcategoria_id = 74;
                    $product->categoria_id = 14;
                    $product->search = "BEBIDAS,TAZAS Y TARROS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BEBIDAS,TAZAS Y TARROS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else{
                    $product->subcategoria_id = 76;
                    $product->categoria_id = 14;
                    $product->search = "BEBIDAS,TERMOS DE PLASTICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BEBIDAS,TERMOS DE PLASTICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            case 'TAZAS':
                $product->categoria_id = 14; 
                $product->subcategoria_id = 74;
                $product->search = "BEBIDAS,TAZAS Y TARROS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "BEBIDAS,TAZAS Y TARROS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'CILINDROS METALICOS':
                $product->categoria_id = 14; 
                $product->subcategoria_id = 72;
                $product->search = "BEBIDAS,CILINDROS METALICOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "BEBIDAS,CILINDROS METALICOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'TERMO METALICO':
                $product->categoria_id = 14; 
                $product->subcategoria_id = 77;
                $product->search = "BEBIDAS,TERMO METALICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "BEBIDAS,TERMO METALICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'USB':
                $product->categoria_id = 1; 
                $product->subcategoria_id = 3;
                $product->search = "TECNOLOGIA,USB, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "TECNOLOGIA,USB, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
            case 'BOLIGRAFOS METALICOS':
                if(Str::contains($item['material'],"Cartón / Plástico") || Str::contains($item['material'],"Cartón / Plástico / Trigo") || Str::contains($item['material'],"Plástico / Bambú / Trigo")){
                    $product->subcategoria_id = 10;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS,BOLIGRAFOS ECOLOGICOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS,BOLIGRAFOS ECOLOGICOS, " . $item['family'] . ', ' . Str::upper($item['name']);

                    $product_T = new Product();
                    $product_T->code = $item['item_code']; //string
                    $product_T->name = $item['name'];
                    $product_T->parent_code = $item['parent_code'];
                    $product_T->details = $item['description'];
                    $product_T->images = json_encode(array($item['img'])); //JSON
                    $product_T->colors = json_encode($colors);
                    $product_T->proveedor = 'PromoOpcion';
                    $product_T->box_pieces = (int)$item['count_box']; // int
                    $product_T->printing_area = $item['printing_area']; //stirng
                    $product_T->printing_methods = json_encode($printing); // string
                    $product_T->nw = $item['nw']." kg"; //string -> se necesita agregar "KG"
                    $product_T->gw = $item['gw']." kg"; //string -> se necesita agregar "KG"
                    $product_T->medida_producto_alto = $item['height']; // int
                    $product_T->medida_producto_ancho = $item['width']; //int
                    $product_T->material = $item['material']; //string 
                    $product_T->capacity = $item['capacity']; //string
                    $product_T->category = $item['family'];
                    $product_T->custom = false;
                    $product_T->search = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO, ECOLOGÍA, ECOLÓGICO, ECOLOGICO, ECOLÓGICA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product_T->meta_keywords = "BOLIGRAFO PLASTICO,BOLIGRAFO DE PLASTICO, ECOLOGÍA, ECOLÓGICO, ECOLOGICO, ECOLÓGICA, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product_T->subcategoria_id = 37;
                    $product_T->categoria_id = 8;
                    $product_T->save();
                    break;
                }else if(Str::contains($item['description'],"marcatextos")){
                    $product->subcategoria_id = 55;
                    $product->categoria_id = 10;
                    $product->search = "OFICINA,MARCA TEXTOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "OFICINA,MARCA TEXTOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"set")){
                    $product->subcategoria_id = 12;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS,SET DE BOLIGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS,SET DE BOLIGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"usb")){
                    $product->subcategoria_id = 8;
                    $product->categoria_id = 2;
                    $product->search = "TECNOLOGIA,USB, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "TECNOLOGIA,USB, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['description'],"ESTUCHE")){
                    $product->subcategoria_id = 11;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS,ESTUCHES DE REGALO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS,ESTUCHES DE REGALO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['material'],"plástico")){
                    $product->subcategoria_id = 9;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS,BOLIGRAFO DE PLASTICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS,BOLIGRAFO DE PLASTICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['material'],"Aleación Cobre") || Str::contains($item['material'],"Acero Inoxidable" )|| Str::contains($item['material'],"Aluminio")){
                    $product->subcategoria_id = 7;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS,BOLIGRAGO METALICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS,BOLIGRAGO METALICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['material'],"Metal") || Str::contains($item['material'],"Aleación Cobre / Fibra de Carbono") || Str::contains($item['material'],"Aleación Cobre / Aluminio")){
                    $product->subcategoria_id = 7;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS,BOLIGRAFO METALICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS,BOLIGRAFO METALICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else if(Str::contains($item['material'],"Acero Inoxidable / Curpiel")){
                    $product->subcategoria_id = 7;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS,BOLIGRAFO METALICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS,BOLIGRAFO METALICO, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }else{
                    $product->subcategoria_id = 15;
                    $product->categoria_id = 2;
                    $product->search = "BOLIGRAFOS,OTROS BOLIGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    $product->meta_keywords = "BOLIGRAFOS,OTROS BOLIGRAFOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                    break;
                }
            
            default:
                $product->categoria_id = 20; 
                $product->subcategoria_id = 93;
                $product->search = "OTROS,VARIOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                $product->meta_keywords = "OTROS,VARIOS, " . $item['family'] . ', ' . Str::upper($item['name']);
                break;
        }

        $product->save();
    }
}
