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
        Schema::create('order_x_product', function (Blueprint $table) {
            $table->id();
            // FK - ORDER
            $table->foreignUuid('order_id');
            
            // FK - PRODUCT
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->string('name')->default('Sin definir');
            $table->string('printing_area')->default('Sin definir');
            $table->string('pantone')->default('Sin definir');
            $table->string('typography')->default('Sin definir');
            $table->integer('num_ink')->default(0);
            $table->integer('num_pzas')->default(0);
            $table->double('price_x_unid')->default(0.0);
            $table->string('printing_method')->default('Sin definir');
            $table->string('provider')->default('ALPHAPROMOS');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_x_product');
    }
};
