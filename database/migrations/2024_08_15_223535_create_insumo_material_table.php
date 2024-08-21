<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumoMaterialTable extends Migration
{
    public function up()
    {
        Schema::create('insumo_material', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idInsumo');
            $table->unsignedBigInteger('idMaterial');
            $table->foreign('idInsumo')->references('id')->on('insumos')->onDelete('cascade');
            $table->foreign('idMaterial')->references('id')->on('material')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insumo_material');
    }
}
