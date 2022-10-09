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
        Schema::create('wardships', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id', false, true);
            $table->tinyInteger('gender_id', false, true);
            $table->bigInteger('city_id', false, true);
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('document')->unique();
            $table->string('uuid')->unique();
            $table->string('address');
            $table->string('zip_code');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wardships');
    }
};