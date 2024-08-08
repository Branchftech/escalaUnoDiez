<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresosTable extends Migration
{
    public function up()
    {
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->decimal('cantidad', 10, 2);
            $table->string('cheque');
            $table->unsignedBigInteger('idObra');
            $table->foreign('idObra')->references('id')->on('obra');
            $table->unsignedBigInteger('idCliente');
            $table->foreign('idCliente')->references('id')->on('cliente');
            $table->unsignedBigInteger('idFormaPago');
            $table->foreign('idFormaPago')->references('id')->on('formaPago');
            $table->unsignedBigInteger('idBanco');
            $table->foreign('idBanco')->references('id')->on('banco');
            $table->unsignedBigInteger('idServicio');
            $table->foreign('idServicio')->references('id')->on('servicio');
            $table->string('concepto', 100);
            $table->date('fecha');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('egresos');
    }
}
