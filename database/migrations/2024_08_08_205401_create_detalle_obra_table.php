<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleObraTable extends Migration
{
    public function up()
    {
        Schema::create('detalleObra', function (Blueprint $table) {
            $table->id();
            $table->string('nombreObra', 100);
            $table->decimal('total', 10, 2);
            $table->enum('moneda', ['mnx', 'dls']);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('croquis');
            $table->string('calle', 100);
            $table->string('manzana', 100);
            $table->string('lote', 100);
            $table->integer('metros_cuadrados');
            $table->string('fraccionamiento')->nullable();
            $table->string('dictamenUsoSuelo')->nullable();
            $table->string('incrementoDensidad')->nullable();
            $table->integer('informeDensidad')->nullable();
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
        Schema::dropIfExists('detalleObra');
    }
}
