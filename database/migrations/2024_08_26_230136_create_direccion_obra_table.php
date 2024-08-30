<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionObraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direccionObra', function (Blueprint $table) {
            $table->id();
            $table->string('calle', 100);
            $table->string('manzana', 100);
            $table->string('lote', 100);
            $table->integer('metrosCuadrados');
            $table->string('fraccionamiento')->nullable();
            $table->unsignedBigInteger('idPais')->nullable();
            $table->unsignedBigInteger('idEstado')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('idPais')->references('id')->on('paises')->onDelete('set null');
            $table->foreign('idEstado')->references('id')->on('estados')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccionObra');
    }
};
