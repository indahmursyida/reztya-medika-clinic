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
            $table->id('order_id');
            $table->foreignId('cancel_id')->nullable();
            $table->foreignId('payment_receipt_id')->nullable();
            $table->foreignId('user_id');
            $table->date('order_date');
            $table->string('status', 255);
            $table->boolean('delivery_service')->nullable();
            $table->string('delivery_name')->nullable();
            $table->string('delivery_duration')->nullable();
            $table->string('weight')->nullable();
            $table->string('delivery_destination')->nullable();
            $table->integer('delivery_fee')->length(11)->nullable();
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
        Schema::dropIfExists('orders');
    }
};
