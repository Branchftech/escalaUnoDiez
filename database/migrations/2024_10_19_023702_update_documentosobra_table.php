<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDocumentosObraTable extends Migration
{
    public function up()
    {
        Schema::table('documentoobra', function (Blueprint $table) {
            // Cambiar los campos para que sean nullable
            $table->text('nombre')->nullable()->change();
        });
    }

    public function down()
{
    Schema::table('documentoobra', function (Blueprint $table) {
        // Revertir los cambios
        $table->text('nombre')->nullable(false)->change();
    });
}
}
