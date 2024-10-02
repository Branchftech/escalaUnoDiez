<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestajoServicioTable extends Migration
{
    public function up()
    {
        Schema::create('destajo_servicio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idServicio');
            $table->unsignedBigInteger('idDestajo');
            $table->foreign('idServicio')->references('id')->on('servicio')->onDelete('cascade');
            $table->foreign('idDestajo')->references('id')->on('destajo')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('destajo_servicio');
    }
}
