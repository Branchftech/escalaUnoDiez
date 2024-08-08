<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoObraTable extends Migration
{
    public function up()
    {
        Schema::create('estadoObra', function (Blueprint $table) {
            $table->id();
            $table->string('estado', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estadoObra');
    }
}
