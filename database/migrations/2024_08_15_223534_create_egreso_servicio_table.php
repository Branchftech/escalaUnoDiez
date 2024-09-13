<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresoServicioTable extends Migration
{
    public function up()
    {
        Schema::create('egreso_servicio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idEgreso');
            $table->unsignedBigInteger('idServicio');
            $table->foreign('idEgreso')->references('id')->on('egresos');
            $table->foreign('idServicio')->references('id')->on('servicio');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('egreso_servicio');
    }
}
