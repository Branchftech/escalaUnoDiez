<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->string('factura');
            $table->decimal('cantidad', 10, 2);
            $table->unsignedBigInteger('idCliente');
            $table->foreign('idCliente')->references('id')->on('cliente');
            $table->unsignedBigInteger('idFormaPago');
            $table->foreign('idFormaPago')->references('id')->on('formaPago');
            $table->unsignedBigInteger('idBanco');
            $table->foreign('idBanco')->references('id')->on('banco');
            $table->string('concepto', 100);
            $table->date('fecha');
            $table->unsignedBigInteger('idObra');
            $table->foreign('idObra')->references('id')->on('obra');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingresos');
    }
}
