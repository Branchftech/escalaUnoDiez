<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesoTable extends Migration
{
    public function up()
    {
        Schema::create('acceso', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('url');
            $table->string('icono');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('acceso');
    }
}
