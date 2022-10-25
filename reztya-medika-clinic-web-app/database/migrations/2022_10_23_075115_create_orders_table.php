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
            $table->increments('order_id')->primary_key();
            $table->integer('order_detail_id')->unsigned();
            $table->foreign('order_detail_id')->references('order_detail_id')->on('order_details');
            $table->integer('cancel_id')->unsigned();
            $table->foreign('cancel_id')->references('cancel_id')->on('order_cancels');
            $table->integer('payment_receipt_id')->unsigned();
            $table->foreign('payment_receipt_id')->references('payment_receipt_id')->on('payment_receipts');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->date('order_date');
            $table->string('status', 255);
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
