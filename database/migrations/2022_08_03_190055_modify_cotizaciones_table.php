<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $set_schema_table = 'cotizaciones';

    public function up()
    {
        // Status de la cotizacion
        // Estados: Pendiente, Cancelada, Aprobada
        \DB::raw("ALTER TABLE cotizaciones MODIFY COLUMN status ENUM('Aprobada', 'Cancelada', 'Pendiente', 'En Proceso') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
