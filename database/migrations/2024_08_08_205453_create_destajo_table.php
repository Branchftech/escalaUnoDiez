<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestajoTable extends Migration
{
    public function up()
    {
        Schema::create('destajo', function (Blueprint $table) {
            $table->id();
            $table->decimal('presupuesto', 10, 2);
            $table->unsignedBigInteger('idObra');
            $table->foreign('idObra')->references('id')->on('obra');
            $table->unsignedBigInteger('idCliente');
            $table->foreign('idCliente')->references('id')->on('cliente');
            $table->unsignedBigInteger('idServicio');
            $table->foreign('idServicio')->references('id')->on('servicio');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('destajo');
    }
}
