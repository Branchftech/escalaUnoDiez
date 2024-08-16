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
            $table->unsignedBigInteger('created_by')->nullable(); 
            $table->unsignedBigInteger('updated_by')->nullable(); 
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
       
        
    }

    public function down()
    {
        Schema::dropIfExists('banco');
    }
}
