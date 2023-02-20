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
        Schema::create('shippment', function (Blueprint $table) {
            $table->id();
            // FK - ORDER
            $table->foreignUuid('order_id');

            $table->enum('warehouse', ['AJUSCO', 'CANCUN-SMZ32', 'MADRID']);
            $table->enum('country', ['MÉXICO', 'ESPAÑA']);
            $table->string('destination');
            $table->enum('shippment_status', ['DELIVERED', 'PENDANT', 'IN_PROCESS', 'CANCEL']);
            $table->json('photos')->nullable();
            $table->double('shippment_fee')->default(0.0);
            $table->string('accompanion');
            $table->string('reciever')->default('Sin definir');
            $table->string('code_area');
            $table->string('phone');
            $table->longText('details')->nullable();
            // FK - USER
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
        Schema::dropIfExists('shippment');
    }
};
