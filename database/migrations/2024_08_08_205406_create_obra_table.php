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
            $table->unsignedBigInteger('idCliente');
            $table->foreign('idCliente')->references('id')->on('cliente');
            $table->unsignedBigInteger('idEstadoObra');
            $table->foreign('idEstadoObra')->references('id')->on('estadoobra');
            $table->string('licenciaConstruccion', 100);
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
        Schema::dropIfExists('obra');
    }
}
