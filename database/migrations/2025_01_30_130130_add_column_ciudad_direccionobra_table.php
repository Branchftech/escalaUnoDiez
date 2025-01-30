
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCiudadDireccionObraTable extends Migration
{
    public function up()
    {
        Schema::table('direccionobra', function (Blueprint $table) {
            // agregar la relacion con ciudad
            $table->unsignedBigInteger('idCiudad')->nullable();
            $table->foreign('idCiudad')->references('id')->on('ciudades')->onDelete('set null');

        });
    }

    public function down()
    {
        Schema::table('direccionobra', function (Blueprint $table) {
            // Eliminar la clave foránea primero
            $table->dropForeign(['idCiudad']);

            // Luego eliminar la columna
            $table->dropColumn('idCiudad');
        });
    }
}
