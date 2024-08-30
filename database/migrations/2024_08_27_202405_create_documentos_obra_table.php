<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosObraTable extends Migration
{
    public function up()
    {
        Schema::create('documentoobra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idObra');
            $table->unsignedBigInteger('idTipoDocumento');
            $table->text('nombre');
            $table->text('path');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');

            // Definir la relación con la tabla 'obras'
            $table->foreign('idObra')->references('id')->on('obra')->onDelete('cascade');
            // Definir la relación con la tabla 'tipos_documento'
            $table->foreign('idTipoDocumento')->references('id')->on('tipodocumentoobra')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentoobra');
    }
}
