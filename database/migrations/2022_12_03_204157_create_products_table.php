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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable(true);
            $table->string('parent_code')->nullable(true)->default(null);
            $table->double('discount', 8, 2)->default(0.0);
            $table->json('colors')->nullable(true)->default(null);
            $table->longText('details')->nullable()->default(null);
            $table->integer('stock')->nullable()->default(null);
            $table->double('price', 8, 2)->nullable()->default(null);
            $table->string('nw')->nullable()->default(null); //Peso Neto - Net Weight - caja
            $table->string('gw')->nullable()->default(null); //Peso Bruto - Gross Weight - caja
            $table->string('weight_product')->nullable()->default(null); //Peso Producto
            $table->string('medida_producto_alto')->nullable()->default(null);
            $table->string('medida_producto_ancho')->nullable()->default(null);
            $table->string('printing_area')->nullable()->default(null);
            $table->json('printing_methods')->nullable()->default(null);
            $table->string('category')->nullable()->default(null);
            $table->string('subcategory')->nullable()->default(null);
            $table->integer('box_pieces')->nullable()->default(null);
            $table->string('capacity')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->string('material')->nullable()->default(null);
            $table->boolean('batteries')->default(false);
            $table->string('proveedor')->default('AlphaPromos');
            $table->boolean('custom')->nullable();

            //Texto para Busqueda
            $table->longText('search')->nullable();

            //FK de Producto --> Categorias
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');

            //FK de Producto --> Subcategorias
            $table->unsignedBigInteger('subcategoria_id');
            $table->foreign('subcategoria_id')->references('id')->on('subcategorias');

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
        Schema::dropIfExists('products');
    }
};
