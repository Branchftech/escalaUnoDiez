
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDireccionObraTable extends Migration
{
    public function up()
    {
        Schema::table('direccionobra', function (Blueprint $table) {
            // Cambiar los campos para que sean nullable
            $table->string('manzana', 100)->nullable()->change();
            $table->string('lote', 100)->nullable()->change();
            $table->integer('metrosCuadrados')->nullable()->change();
            $table->string('fraccionamiento')->nullable(false)->change();
        });
    }

    public function down()
{
    Schema::table('direccionobra', function (Blueprint $table) {
        // Revertir los cambios
        $table->string('manzana', 100)->nullable(false)->change();
        $table->string('lote', 100)->nullable(false)->change();
        $table->integer('metrosCuadrados')->nullable(false)->change();
        $table->string('fraccionamiento')->nullable()->change();
    });
}
}
