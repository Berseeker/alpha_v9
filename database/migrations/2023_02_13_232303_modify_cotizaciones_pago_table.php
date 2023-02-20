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
        \DB::statement("ALTER TABLE ".$this->set_schema_table." MODIFY COLUMN forma_pago ENUM('Tarjeta', 'Cancelada', 'Efectivo', 'Transferencia', 'Otro') NOT NULL");
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
