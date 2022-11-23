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
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('gender_id', false, true)->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('document')->unique();
            $table->string('uuid')->unique();
            $table->string('address');
            $table->string('zip_code');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('gender_id')->references('id')->on('genders')->nullOnDelete()->nullOnUpdate();;
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
