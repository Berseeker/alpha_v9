<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SubcategoryImgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //audifonos
        DB::table('subcategorias')
              ->where('id', 1)
              ->update(['imgs' => 'headphones.png']);

        //bocinas
        DB::table('subcategorias')
              ->where('id', 2)
              ->update(['imgs' => 'bocinas.png']);

        //usb
        DB::table('subcategorias')
              ->where('id', 3)
              ->update(['imgs' => 'memoria_usb.png']);

        //accesorios computo
        DB::table('subcategorias')
              ->where('id', 4)
              ->update(['imgs' => 'computo.png']);

        //accesorios telefono
        DB::table('subcategorias')
              ->where('id', 5)
              ->update(['imgs' => 'telefonos.png']);

        //otros tecnologia
        DB::table('subcategorias')
              ->where('id', 6)
              ->update(['imgs' => 'tecnologia_otros.png']);

        //boligrafo metalico
        DB::table('subcategorias')
              ->where('id', 7)
              ->update(['imgs' => 'boligrafo_metal.png']);

        //boligrafo multifuncional
        DB::table('subcategorias')
              ->where('id', 8)
              ->update(['imgs' => 'boligrafo_multifuncional.png']);

        //boligrafos plastico
        DB::table('subcategorias')
              ->where('id', 9)
              ->update(['imgs' => 'boligrafo_plastico.png']);

        //boligrafos ecologicos
        DB::table('subcategorias')
              ->where('id', 10)
              ->update(['imgs' => 'boligrafo_ecologico.png']);

        //estuches regalo
        DB::table('subcategorias')
              ->where('id', 11)
              ->update(['imgs' => 'estuches.png']);

        //set boligrafo
        DB::table('subcategorias')
              ->where('id', 12)
              ->update(['imgs' => 'sets.png']);

        //lapices
        DB::table('subcategorias')
              ->where('id', 13)
              ->update(['imgs' => 'pencils.png']);

        //ejecutivo
        DB::table('subcategorias')
              ->where('id', 14)
              ->update(['imgs' => 'ejecutive.png']);

        //otros boligrafos
        DB::table('subcategorias')
              ->where('id', 15)
              ->update(['imgs' => 'boligrafo_otros.png']);

        //salud
        DB::table('subcategorias')
              ->where('id', 16)
              ->update(['imgs' => 'salud.png']);

        //belleza
        DB::table('subcategorias')
              ->where('id', 17)
              ->update(['imgs' => 'belleza.png']);

        //cosmetiquera
        DB::table('subcategorias')
              ->where('id', 18)
              ->update(['imgs' => 'cosmetiqueras.png']);

        //ciudado personal
        DB::table('subcategorias')
              ->where('id', 19)
              ->update(['imgs' => 'cuidado_personal.png']);

        //viaje
        DB::table('subcategorias')
              ->where('id', 20)
              ->update(['imgs' => 'viaje.png']);

        //brazaletes
        DB::table('subcategorias')
              ->where('id', 21)
              ->update(['imgs' => 'brazaletes.png']);

        //bolsas y morrales
        DB::table('subcategorias')
              ->where('id', 22)
              ->update(['imgs' => 'bolsa_morral.png']);

        //bolsas ecologicas
        DB::table('subcategorias')
              ->where('id', 23)
              ->update(['imgs' => 'bolsa_ecologica.png']);

        //mochilas
        DB::table('subcategorias')
              ->where('id', 24)
              ->update(['imgs' => 'mochilas.png']);

        //maletas
        DB::table('subcategorias')
              ->where('id', 25)
              ->update(['imgs' => 'maletas.png']);

        //loncheras y hieleras
        DB::table('subcategorias')
              ->where('id', 26)
              ->update(['imgs' => 'lonchera_hielera.png']);

        //gorras
        DB::table('subcategorias')
              ->where('id', 27)
              ->update(['imgs' => 'gorras_cangureras.png']);

        //portafolios
        DB::table('subcategorias')
              ->where('id', 28)
              ->update(['imgs' => 'portafolios.png']);

        //maletines
        DB::table('subcategorias')
              ->where('id', 29)
              ->update(['imgs' => 'maletines.png']);

        //chamarras y chalecos
        DB::table('subcategorias')
              ->where('id', 30)
              ->update(['imgs' => 'chamarra_chalecos.png']);

        //playeras
        DB::table('subcategorias')
              ->where('id', 31)
              ->update(['imgs' => 'playeras.png']);

        //paraguas
        DB::table('subcategorias')
              ->where('id', 32)
              ->update(['imgs' => 'paraguas.png']);

        //herramientas
        DB::table('subcategorias')
              ->where('id', 33)
              ->update(['imgs' => 'tools.png']);

        //lamparas 
        DB::table('subcategorias')
              ->where('id', 34)
              ->update(['imgs' => 'lamps.png']);

        //navajas multifuncion 
        DB::table('subcategorias')
              ->where('id', 35)
              ->update(['imgs' => 'navajas_multifuncion.png']);

        //flexometro 
        DB::table('subcategorias')
              ->where('id', 36)
              ->update(['imgs' => 'flexometro.png']);

        //boligrafo ecologico
        DB::table('subcategorias')
              ->where('id', 37)
              ->update(['imgs' => 'boligrafo_ecologico.png']);

        //libreta ecologica 
        DB::table('subcategorias')
              ->where('id', 38)
              ->update(['imgs' => 'libreta_ecologica.png']);

        //notas 
        DB::table('subcategorias')
              ->where('id', 39)
              ->update(['imgs' => 'notas.png']);

        //bolsas ecologicas
        DB::table('subcategorias')
              ->where('id', 40)
              ->update(['imgs' => 'bolsa_ecologica.png']);

        //otros ecologicos 
        DB::table('subcategorias')
              ->where('id', 41)
              ->update(['imgs' => 'ecologicos_otros.png']);

        //cocina 
        DB::table('subcategorias')
              ->where('id', 42)
              ->update(['imgs' => 'kitchen.png']);

        //bar 
        DB::table('subcategorias')
              ->where('id', 43)
              ->update(['imgs' => 'bar.png']);

        //bbq 
        DB::table('subcategorias')
              ->where('id', 44)
              ->update(['imgs' => 'bbq.png']);

        //otros hogar 
        DB::table('subcategorias')
              ->where('id', 45)
              ->update(['imgs' => 'hogar_otros.png']);

        //portarretratos
        DB::table('subcategorias')
              ->where('id', 46)
              ->update(['imgs' => 'portarretrato.png']);

        //accesorios oficina
        DB::table('subcategorias')
              ->where('id', 47)
              ->update(['imgs' => 'oficina_accesorios.png']);

        //libretas 
        DB::table('subcategorias')
              ->where('id', 48)
              ->update(['imgs' => 'libretas.png']);

        //carpetas 
        DB::table('subcategorias')
              ->where('id', 49)
              ->update(['imgs' => 'carpetas.png']);

        //calculadoras 
        DB::table('subcategorias')
              ->where('id', 50)
              ->update(['imgs' => 'calculadoras.png']);

        //porta documentos 
        DB::table('subcategorias')
              ->where('id', 51)
              ->update(['imgs' => 'porta_documentos.png']);

        //tarjeteros 
        DB::table('subcategorias')
              ->where('id', 52)
              ->update(['imgs' => 'tarjeteros.png']);

        //portagafetes 
        DB::table('subcategorias')
              ->where('id', 53)
              ->update(['imgs' => 'portagafetes.png']);

        //agendas 
        DB::table('subcategorias')
              ->where('id', 54)
              ->update(['imgs' => 'agendas.png']);

        //marca textos 
        DB::table('subcategorias')
              ->where('id', 55)
              ->update(['imgs' => 'marca_textos.png']);

        //deportes
        DB::table('subcategorias')
              ->where('id', 56)
              ->update(['imgs' => 'sports.png']);

        //entretenimiento
        DB::table('subcategorias')
              ->where('id', 57)
              ->update(['imgs' => 'entertainment.png']);

        //mascotas 
        DB::table('subcategorias')
              ->where('id', 58)
              ->update(['imgs' => 'pets.png']);

        //antiestres 
        DB::table('subcategorias')
              ->where('id', 59)
              ->update(['imgs' => 'antiestres.png']);

        //varios antiestres
        DB::table('subcategorias')
              ->where('id', 60)
              ->update(['imgs' => 'antiestres.png']);

        //tazas 
        DB::table('subcategorias')
              ->where('id', 61)
              ->update(['imgs' => 'tazas.png']);

        //libretas 
        DB::table('subcategorias')
              ->where('id', 62)
              ->update(['imgs' => 'libretas.png']);

        //vasos y tarros 
        DB::table('subcategorias')
              ->where('id', 63)
              ->update(['imgs' => 'vasos_tarros.png']);

        //termos 
        DB::table('subcategorias')
              ->where('id', 64)
              ->update(['imgs' => 'termos.png']);

        //cilindro metalico 
        DB::table('subcategorias')
              ->where('id', 65)
              ->update(['imgs' => 'cilindro_metal.png']);

        //accesorios oficina
        DB::table('subcategorias')
              ->where('id', 66)
              ->update(['imgs' => 'oficina_accesorios.png']);

        //textil 
        DB::table('subcategorias')
              ->where('id', 67)
              ->update(['imgs' => 'textil.png']);

        //varios textil 
        DB::table('subcategorias')
              ->where('id', 68)
              ->update(['imgs' => 'textil_varios.png']);

        //fundas 
        DB::table('subcategorias')
              ->where('id', 69)
              ->update(['imgs' => 'fundas.png']);

        //decorativos 
        DB::table('subcategorias')
              ->where('id', 70)
              ->update(['imgs' => 'decorativos.png']);

        //cilindros plastico 
        DB::table('subcategorias')
              ->where('id', 71)
              ->update(['imgs' => 'cilindros_plastico.png']);

        //cilindros metalico 
        DB::table('subcategorias')
              ->where('id', 72)
              ->update(['imgs' => 'cilindro_metal.png']);

        //cilindro vidrio 
        DB::table('subcategorias')
              ->where('id', 73)
              ->update(['imgs' => 'cilindro_vidrio.png']);

        //tazas y tarros 
        DB::table('subcategorias')
              ->where('id', 74)
              ->update(['imgs' => 'tazas_tarros.png']);

        //vasos 
        DB::table('subcategorias')
              ->where('id', 75)
              ->update(['imgs' => 'vaso.png']);

        //termo plastico 
        DB::table('subcategorias')
              ->where('id', 76)
              ->update(['imgs' => 'termo_plastico.png']);

        //termo metalico 
        DB::table('subcategorias')
              ->where('id', 77)
              ->update(['imgs' => 'termo_metal.png']);

        //llaveros multifuncionales 
        DB::table('subcategorias')
              ->where('id', 79)
              ->update(['imgs' => 'llavero_multifuncional.png']);

        //llavero metalico 
        DB::table('subcategorias')
              ->where('id', 80)
              ->update(['imgs' => 'llavero_metal.png']);

        //llavero plastico 
        DB::table('subcategorias')
              ->where('id', 81)
              ->update(['imgs' => 'llavero_plastico.png']);

        //llavero luminoso 
        DB::table('subcategorias')
              ->where('id', 82)
              ->update(['imgs' => 'llavero_luminoso.png']);

        //llavero madera 
        DB::table('subcategorias')
              ->where('id', 83)
              ->update(['imgs' => 'llavero_madera.png']);

        //otros llaveros 
        DB::table('subcategorias')
              ->where('id', 84)
              ->update(['imgs' => 'llavero_otros.png']);

        //estuches 
        DB::table('subcategorias')
              ->where('id', 86)
              ->update(['imgs' => 'estuches.png']);

        //reloj pared escritorio 
        DB::table('subcategorias')
              ->where('id', 87)
              ->update(['imgs' => 'reloj_pared.png']);

        //reloj de pulso
        DB::table('subcategorias')
              ->where('id', 88)
              ->update(['imgs' => 'reloj_pulso.png']);

        //sets
        DB::table('subcategorias')
              ->where('id', 89)
              ->update(['imgs' => 'set_boligrafos.png']);

        //accesorios auto 
        DB::table('subcategorias')
              ->where('id', 90)
              ->update(['imgs' => 'auto_partes.png']);

        //kids 
        DB::table('subcategorias')
              ->where('id', 91)
              ->update(['imgs' => 'kids.png']);

        //escolares 
        DB::table('subcategorias')
              ->where('id', 92)
              ->update(['imgs' => 'escolares.png']);

        //articulos contingencia
        DB::table('subcategorias')
              ->where('id', 94)
              ->update(['imgs' => 'contingencia.png']);

        //termos 
        DB::table('subcategorias')
              ->where('id', 95)
              ->update(['imgs' => 'termos.png']);

        //recreacion 
        DB::table('subcategorias')
              ->where('id', 96)
              ->update(['imgs' => 'recreacion.png']);

        //otros relojes 
        DB::table('subcategorias')
              ->where('id', 97)
              ->update(['imgs' => 'relojes_otros.png']);
    }
}
