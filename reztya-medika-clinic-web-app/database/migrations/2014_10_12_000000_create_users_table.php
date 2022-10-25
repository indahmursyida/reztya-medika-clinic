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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id')->primary_key();
            $table->integer('user_role_id');
            $table->string('full_name', 255);
            $table->date('birth_date');
            $table->string('phone_number', 255);
            $table->string('address', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->boolean('is_banned');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
