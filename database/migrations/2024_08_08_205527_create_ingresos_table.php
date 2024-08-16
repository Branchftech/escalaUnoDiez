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

            $table->unsignedBigInteger('created_by')->nullable(); 
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingresos');
    }
}
