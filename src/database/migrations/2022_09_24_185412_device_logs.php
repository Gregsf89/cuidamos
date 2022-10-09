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
        Schema::create('device_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('device_id', false, true);
            $table->float('latitude', 10, 7, false);
            $table->float('longitude', 10, 7, false);
            $table->float('altitude', 10, 7, false);
            $table->date('date');
            $table->time('time');
            $table->timestamp('created_at')->useCurrent();
            $table->float('speed', 10, 7, false)->nullable();
            $table->float('accuracy', 10, 7, false)->nullable();

            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_logs');
    }
};
