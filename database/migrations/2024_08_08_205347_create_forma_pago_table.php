<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormaPagoTable extends Migration
{
    public function up()
    {
        Schema::create('formaPago', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('formaPago');
    }
}
