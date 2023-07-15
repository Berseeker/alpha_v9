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
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cantidad_piezas');
            $table->date('venta_realizada');
            $table->double('total');
            $table->double('subtotal')->nullable();
            $table->double('mano_obra')->nullable();
            // Status de la cotizacion
            // Estados: Pendiente, Cancelada, Aprobada
            $table->enum('status',['Cancelada','Aprobada']);
            //FK de Cotizacion --> Users
            $table->longText('cotizacion_id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
