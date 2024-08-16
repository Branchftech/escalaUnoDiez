<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorServicioTable extends Migration
{
    public function up()
    {
        Schema::create('proveedor_servicio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idServicio');
            $table->unsignedBigInteger('idProveedor');
            $table->foreign('idServicio')->references('id')->on('servicio')->onDelete('cascade');
            $table->foreign('idProveedor')->references('id')->on('proveedores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedor_servicio');
    }
}
