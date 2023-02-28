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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            // FK - ORDER
            $table->foreignUuid('order_id');
            // FK - PAYMENT
            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payment');
            // FK - SHIPPMENT
            $table->unsignedBigInteger('shippment_id');
            $table->foreign('shippment_id')->references('id')->on('shippment');
            // FK - USERS
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
        Schema::dropIfExists('sales');
    }
};
