<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObrasDocumentoTable extends Migration
{
    public function up()
    {
        Schema::create('obras_documento', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->unsignedBigInteger('subido_por');
            $table->foreign('subido_por')->references('id')->on('users')->onDelete('cascade');
            $table->string('url');
            $table->unsignedBigInteger('idDetalleObra');
            $table->foreign('idDetalleObra')->references('id')->on('detalleObra')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('obras_documento');
    }
}
