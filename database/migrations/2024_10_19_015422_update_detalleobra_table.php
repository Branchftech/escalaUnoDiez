
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDetalleObraTable extends Migration
{
    public function up()
    {
        Schema::table('detalleobra', function (Blueprint $table) {
            // Cambiar los campos para que sean nullable

        $table->string('moneda', 100)->nullable()->change();
        });
    }

    public function down()
{
    Schema::table('detalleobra', function (Blueprint $table) {
        // Revertir los cambios
        $table->string('moneda', 100)->nullable(false)->change();
    });
}
}
