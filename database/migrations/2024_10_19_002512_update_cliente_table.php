<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClienteTable extends Migration
{
    public function up()
    {
        Schema::table('cliente', function (Blueprint $table) {
            // Cambiar los campos para que sean nullable excepto 'nombre'
            $table->string('apellido')->nullable()->change();
            $table->string('telefono')->nullable()->change();
            $table->string('cedula')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    public function down()
{
    Schema::table('cliente', function (Blueprint $table) {
        // Revertir los cambios
        $table->string('apellido')->nullable(false)->change();
        $table->string('telefono')->nullable(false)->change();
        $table->string('cedula')->nullable(false)->change();
        $table->string('email')->nullable(false)->change();
    });
}
}
