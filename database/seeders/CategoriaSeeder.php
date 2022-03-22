<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1. TECNOLOGÍA
        //2. BOLIGRAFOS
        //3. SALUD Y CUIDADO PERSONAL
        //4. VIAJE
        //5. TEXTIL
        //6. PARAGUAS
        //7. HERRAMIENTAS
        //8. ECOLOGICOS
        //9. HOGAR
        //10. OFICINA
        //11. TIEMPO LIBRE
        //12. ANTIESTRÉS
        //13. SUBLIMACIÓN
        //14. BEBIDAS
        //15. LLAVEROS
        //16. OTROS
        //17. RELOJES
        //18. ACCESORIOS PARA AUTO
        //19. KIDS Y ESCOLARES
        //20. ARTICULOS DE HOTELERÍA
        DB::table('categorias')->insert([
            'nombre' => 'TECNOLOGÍA',
            'icon' => "fa-headphones",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'BOLIGRAFOS',
            'icon' => "fa-pen-nib",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'SALUD Y CUIDADO PERSONAL',
            'icon' => "fa-heartbeat",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'VIAJE',
            'icon' => "fa-suitcase-rolling",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'TEXTIL',
            'icon' => "fa-tshirt",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'PARAGUAS',
            'icon' => "fa-umbrella",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'HERRAMIENTAS',
            'icon' => "fa-tools",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'ECOLOGICOS',
            'icon' => "fa-leaf",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'HOGAR',
            'icon' => "fa-home",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'OFICINA',
            'icon' => "fa-briefcase",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'TIEMPO LIBRE',
            'icon' => "fa-futbol",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'ANTIESTRÉS',
            'icon' => "fa-brain",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'SUBLIMACIÓN',
            'icon' => "fa-fill-drip",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'BEBIDAS',
            'icon' => "fa-glass-martini-alt",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'LLAVEROS',
            'icon' => "fa-key",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'OTROS',
            'icon' => "fa-ellipsis-h",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'RELOJES',
            'icon' => "fa-clock",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'ACCESORIOS PARA AUTO',
            'icon' => "fa-car",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'KIDS Y ESCOLARES',
            'icon' => "fa-school",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'ARTICULOS DE HOTELERÍA',
            'icon' => "fa-concierge-bell",
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
