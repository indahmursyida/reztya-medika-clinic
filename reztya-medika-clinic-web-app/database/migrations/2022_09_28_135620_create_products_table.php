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
            $table->increments('product_id')->primaryKey();
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->string('name', 255);
            $table->text('description');
            $table->integer('price')->length(11);
            $table->date('expired_date');
            $table->integer('stock')->length(11);
            $table->string('image_path', 255);
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
