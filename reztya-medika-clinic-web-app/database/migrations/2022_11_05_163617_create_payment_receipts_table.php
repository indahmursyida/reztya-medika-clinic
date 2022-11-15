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
        Schema::create('payment_receipts', function (Blueprint $table) {
            $table->id('payment_receipt_id')->primaryKey();
            $table->foreignId('feedback_id')->nullable();
            $table->date('payment_date')->nullable();;
            $table->integer('payment_amount')->length(11)->nullable();;
            $table->string('payment_method', 15)->nullable();;
            $table->string('account_number', 15)->nullable();
            $table->string('created_by', 255);
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
        //
    }
};
