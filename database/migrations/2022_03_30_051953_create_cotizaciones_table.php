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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('email');
            $table->string('codigo_area');
            $table->bigInteger('celular');
            $table->longText('logo_img')->nullable();
            $table->longText('img_name')->nullable();
            $table->longText('comentarios')->nullable();
            $table->longText('medidas_deseables',100)->nullable();
            $table->longText('fecha_deseable')->nullable();
            $table->longText('pantones')->nullable();
            $table->string('tipografia')->nullable();

            $table->longText('precio_pza')->nullable();
            $table->longText('precio_x_producto')->nullable();
            $table->double('precio_total')->nullable();
            $table->double('precio_subtotal')->nullable();
            $table->double('mano_x_obra')->nullable();

            $table->longText('numero_tintas')->nullable();
            $table->enum('forma_pago',['Tarjeta','Efectivo','Oxxo']);
            $table->longText('numero_pzas')->nullable();
            $table->longText('productos_id')->nullable();
            $table->integer('total_productos')->nullable();
            $table->longText('metodos_impresion')->nullable();

            $table->longText('calle')->nullable();
            $table->string('cp')->nullable();
            $table->string('colonia')->nullable();
            $table->string('estado')->nullable();
            $table->string('no_ext')->nullable();
            // Status de la cotizacion
            // Estados: Pendiente, Cancelada, Aprobada
            $table->enum('status',['Pendiente','Cancelada','Aprobada']);

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
        Schema::dropIfExists('cotizaciones');
    }
};
