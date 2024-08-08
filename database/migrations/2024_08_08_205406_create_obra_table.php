<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObraTable extends Migration
{
    public function up()
    {
        Schema::create('obra', function (Blueprint $table) {
            $table->id();
            $table->string('contrato', 100);
            $table->unsignedBigInteger('idDetalleObra');
            $table->foreign('idDetalleObra')->references('id')->on('detalleObra');
            $table->unsignedBigInteger('idProveedor');
            $table->foreign('idProveedor')->references('id')->on('proveedores');
            $table->unsignedBigInteger('idCliente');
            $table->foreign('idCliente')->references('id')->on('cliente');
            $table->string('licenciaConstruccion', 100);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('obra');
    }
}
