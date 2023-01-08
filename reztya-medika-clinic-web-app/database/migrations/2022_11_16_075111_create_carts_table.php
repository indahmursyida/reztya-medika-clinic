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
        Schema::create('carts', function (Blueprint $table) {
            $table->id('cart_id')->primaryKey();
            $table->foreignId('user_id');
            $table->foreignId('service_id')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->foreignId('schedule_id')->nullable();
            $table->integer('quantity')->length(11)->nullable();
            $table->boolean('home_service')->nullable();
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
