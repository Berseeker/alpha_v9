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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();

            // FK - ORDER
            $table->foreignUuid('order_id');
            $table->enum('payment_status', ['ACCEPTED', 'CANCEL', 'DECLINED', 'IN_PROCESS']);
            $table->enum('payment_format', ['CREDIT/DEBIT CARD', 'TRANSFER', 'OXXO', 'PAY CHECK', 'PAYPAL', 'OTHER']);
            $table->enum('entity', ['SANTANDER', 'BANAMEX', 'BBVA', 'SCOTIABANK', 'BANCOOPEL', 'BANORTE', 'HSBC', 'BANBAJIO', 'BANREGIO', 'SABADELL', 'BANJERCITO', 'INVEX', 'OTRO']);
            $table->double('gross_price')->default(0.0);
            $table->double('net_price')->default(0.0);
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
        Schema::dropIfExists('payment');
    }
};
