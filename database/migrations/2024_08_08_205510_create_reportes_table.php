<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesTable extends Migration
{
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->string('nombreReal', 100);
            $table->string('nombreArchivo', 200);
            $table->unsignedBigInteger('subido_por');
            $table->foreign('subido_por')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable(); 
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reportes');
    }
}
