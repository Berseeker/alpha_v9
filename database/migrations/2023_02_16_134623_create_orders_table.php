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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('order_id')->primary();
            $table->string('name');
            $table->string('lastname');
            $table->string('email');
            $table->string('code_area');
            $table->string('phone');
            $table->boolean('isWhatsApp')->default(false);
            $table->string('country')->default('México');
            $table->string('city')->default('CDMX');
            $table->string('state')->default('Edo. Mex');
            $table->longText('address');
            $table->integer('cp')->default(0000);
            $table->string('ext_num')->default('00-0');
            $table->dateTime('deadline')->nullable();
            $table->enum('order_status', ['APPROVED', 'CANCEL', 'PENDANT', 'REVIEWING']);
            $table->integer('total_products')->default(0);
            $table->longText('comments')->nullable();
            $table->longText('file_path')->nullable();
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('orders');
    }
};
