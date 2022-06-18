<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SubcategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subcategorias')->insert([
            'nombre' => 'AUDÍFONOS',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'BOCINAS',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'USB',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'ACCESORIOS DE CÓMPUTO',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'ACCESORIOS DE SMARTPHONE Y TABLETS',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'OTROS TECNOLOGÍA',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'BOLÍGRAFOS METÁLICOS',
            'categoria_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'BOLÍGRAFOS MULTIFUNCIONALES',
            'categoria_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'BOLÍGRAFOS DE PLASTICO',
            'categoria_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'BOLÍGRAFOS ECOLÓGICOS',
            'categoria_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'ESTUCHES DE REGALO',
            'categoria_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'SET DE BOLIGRAFOS',
            'categoria_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LAPICES',
            'categoria_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'EJECUTIVO',
            'categoria_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'OTROS BOLÍGRAFOS',
            'categoria_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'SALUD',
            'categoria_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'BELLEZA',
            'categoria_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'COSMETIQUERAS',
            'categoria_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'CUIDADO PERSONAL',
            'categoria_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'ACCESORIOS DE VIAJE',
            'categoria_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'BRAZALETES',
            'categoria_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'BOLSAS Y MORRALES',
            'categoria_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'BOLSAS ECOLÓGICAS',
            'categoria_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'MOCHILAS',
            'categoria_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'MALETAS',
            'categoria_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LONCHERAS Y HIELERAS',
            'categoria_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'GORRAS Y CANGURERAS',
            'categoria_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('subcategorias')->insert([
            'nombre' => 'PORTAFOLIOS',
            'categoria_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('subcategorias')->insert([
            'nombre' => 'MALETINES',
            'categoria_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'CHAMARRAS Y CHALECOS',
            'categoria_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'PLAYERAS',
            'categoria_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'PARAGUAS E IMPERMEABLES',
            'categoria_id' => 6,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'HERRAMIENTAS',
            'categoria_id' => 7,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LÁMPARAS',
            'categoria_id' => 7,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'NAVAJAS MULTIFUNCIÓN',
            'categoria_id' => 7,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'FLEXÓMETRO',
            'categoria_id' => 7,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'BOLÍGRAFOS ECOLÓGICOS',
            'categoria_id' => 8,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LIBRETAS ECOLÓGICAS',
            'categoria_id' => 8,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'NOTAS',
            'categoria_id' => 8,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'BOLSAS ECOLÓGICAS',
            'categoria_id' => 8,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'OTROS ECOLÓGICOS',
            'categoria_id' => 8,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'COCINA',
            'categoria_id' => 9,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'BAR',
            'categoria_id' => 9,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'BBQ',
            'categoria_id' => 9,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'OTROS HOGAR',
            'categoria_id' => 9,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'PORTARRETRATOS',
            'categoria_id' => 9,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'ACCESORIOS DE OFICINA',
            'categoria_id' => 10,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LIBRETAS',
            'categoria_id' => 10,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'CARPETAS',
            'categoria_id' => 10,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'CALCULADORAS',
            'categoria_id' => 10,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'PORTA DOCUMENTOS',
            'categoria_id' => 10,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'TARJETEROS',
            'categoria_id' => 10,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'PORTAGAFETES',
            'categoria_id' => 10,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'AGENDAS',
            'categoria_id' => 10,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'MARCA TEXTOS',
            'categoria_id' => 10,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'DEPORTES',
            'categoria_id' => 11,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'ENTRETENIMIENTO',
            'categoria_id' => 11,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'MASCOTAS',
            'categoria_id' => 11,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'ANTIESTRÉS',
            'categoria_id' => 12,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'VARIOS-ANTIESTRÉS',
            'categoria_id' => 12,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'TAZAS',
            'categoria_id' => 13,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LIBRETAS',
            'categoria_id' => 13,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'VASOS Y TARROS',
            'categoria_id' => 13,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'TERMOS',
            'categoria_id' => 13,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'CILINDROS METÁLICOS',
            'categoria_id' => 13,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'ACCESORIOS DE OFICINA',
            'categoria_id' => 13,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'TEXTIL',
            'categoria_id' => 13,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'VARIOS-TEXTIL',
            'categoria_id' => 13,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'FUNDAS',
            'categoria_id' => 13,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'DECORATIVOS',
            'categoria_id' => 13,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'CILINDROS DE PLÁSTICO',
            'categoria_id' => 14,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'CILINDROS METÁLICOS',
            'categoria_id' => 14,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'CILINDROS DE VIDRIO',
            'categoria_id' => 14,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'TAZAS Y TARROS',
            'categoria_id' => 14,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'VASOS',
            'categoria_id' => 14,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'TERMO DE PLÁSTICO',
            'categoria_id' => 14,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'TERMO METÁLICO',
            'categoria_id' => 14,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'REPUESTOS',
            'categoria_id' => 14,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LLAVEROS MULTIFUNCIONALES',
            'categoria_id' => 15,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LLAVEROS METÁLICOS',
            'categoria_id' => 15,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LLAVEROS PLÁSTICO',
            'categoria_id' => 15,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LLAVEROS LUMINOSOS',
            'categoria_id' => 15,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'LLAVEROS MADERA',
            'categoria_id' => 15,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'OTROS LLAVEROS',
            'categoria_id' => 15,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'EXHIBIDORES ACRÍLICO',
            'categoria_id' => 16,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'ESTUCHES',
            'categoria_id' => 17,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'PARED Y ESCRITORIO',
            'categoria_id' => 17,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'RELOJ DE PULSO',
            'categoria_id' => 17,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'SETS',
            'categoria_id' => 17,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'ACCESORIOS PARA AUTO',
            'categoria_id' => 18,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'KIDS',
            'categoria_id' => 19,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'ESCOLARES',
            'categoria_id' => 19,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('subcategorias')->insert([
            'nombre' => 'VARIOS',
            'categoria_id' => 20,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'ARTICULOS CONTINGENCIA',
            'categoria_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'TERMOS',
            'categoria_id' => 14,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'RECREACION',
            'categoria_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('subcategorias')->insert([
            'nombre' => 'OTROS RELOJES',
            'categoria_id' => 17,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
