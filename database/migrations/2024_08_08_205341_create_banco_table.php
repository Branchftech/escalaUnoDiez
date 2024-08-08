<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancoTable extends Migration
{
    public function up()
    {
        Schema::create('banco', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo');
            $table->string('nombre', 100);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banco');
    }
}
