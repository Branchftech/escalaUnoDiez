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
            $table->date('fechaInicio');
            $table->date('fechaFin');
            $table->string('dictamenUsoSuelo')->nullable();
            $table->unsignedBigInteger('idDireccionObra')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('idDireccionObra')->references('id')->on('direccionobra')->onDelete('set null');
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
