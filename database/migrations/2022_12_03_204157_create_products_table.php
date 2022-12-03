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
            $table->string('id_product')->nullable(true);
            $table->double('discount', 8, 2)->default(0.0);
            $table->json('color')->nullable(true)->default(null);
            $table->longText('details')->nullable()->default(null);
            $table->integer('stock')->nullable()->default(null);
            $table->double('price', 8, 2)->nullable()->default(null);
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
