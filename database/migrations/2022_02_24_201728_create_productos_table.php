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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nickname')->nullable();
            $table->string('SDK');
            $table->longText('descripcion')->nullable();
            $table->longText('images')->nullable();
            $table->longText('color')->nullable();
            $table->string('proveedor');
            $table->bigInteger('piezas_caja')->nullable();
            $table->string('area_impresion')->nullable();
            $table->string('metodos_impresion')->nullable();
            $table->string('peso_caja')->nullable();
            //Medidas del producto
            $table->string('medida_producto_ancho')->nullable();
            $table->string('medida_producto_alto')->nullable();
            $table->string('medidas_producto_general')->nullable();
            //Medidas de la caja de embalaje
            $table->bigInteger('alto_caja')->nullable();
            $table->bigInteger('ancho_caja')->nullable();
            $table->bigInteger('largo_caja')->nullable();
            //Medida de la caja master
            $table->string('caja_master')->nullable();
            
            $table->string('modelo')->nullable();

            $table->string('material')->nullable();
            $table->string('capacidad')->nullable();
            
            //Si el articulo se encuentra en promoción
            $table->boolean('promocion')->nullable();
            $table->longText('file_name')->nullable();
            $table->boolean('custom')->nullable();

            //Texto para Busqueda
            $table->longText('busqueda')->nullable();

            //FK de Producto --> Categorias
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');

            //FK de Producto --> Subcategorias
            $table->unsignedBigInteger('subcategoria_id');
            $table->foreign('subcategoria_id')->references('id')->on('subcategorias');

            $table->integer('existencias')->nullable();


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
        Schema::dropIfExists('productos');
    }
};
