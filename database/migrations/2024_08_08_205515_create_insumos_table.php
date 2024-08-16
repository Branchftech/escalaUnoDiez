<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumosTable extends Migration
{
    public function up()
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->decimal('costo', 10, 2);
            $table->integer('cantidad');
            $table->unsignedBigInteger('idUnidad');
            $table->foreign('idUnidad')->references('id')->on('unidad');
            $table->unsignedBigInteger('idObra');
            $table->foreign('idObra')->references('id')->on('detalleObra');
            $table->unsignedBigInteger('idMaterial');
            $table->foreign('idMaterial')->references('id')->on('material');
            $table->date('fecha');
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
        Schema::dropIfExists('insumos');
    }
}
