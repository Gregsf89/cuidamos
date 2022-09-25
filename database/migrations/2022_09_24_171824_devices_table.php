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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wardship_id', false, true);
            $table->string('imei')->unique();
            $table->string('uuid')->unique();
            $table->string('carrier_name');
            $table->string('carrier_number');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('wardship_id')->references('id')->on('wardships')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
};
