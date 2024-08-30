<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorObraTable extends Migration
{
    public function up()
    {
        Schema::create('proveedor_obra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idObra');
            $table->unsignedBigInteger('idProveedor');
            $table->foreign('idObra')->references('id')->on('obra');
            $table->foreign('idProveedor')->references('id')->on('proveedores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedor_obra');
    }
}
