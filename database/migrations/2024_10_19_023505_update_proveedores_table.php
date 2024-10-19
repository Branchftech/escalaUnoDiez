
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProveedoresTable extends Migration
{
    public function up()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            // Cambiar los campos para que sean nullable
            $table->string('direccion')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('telefono')->nullable()->change();
        });
    }

    public function down()
{
    Schema::table('proveedores', function (Blueprint $table) {
        // Revertir los cambios
        $table->string('direccion')->nullable(false)->change();
        $table->string('email')->nullable(false)->change();
        $table->string('telefono')->nullable(false)->change();
    });
}
}
