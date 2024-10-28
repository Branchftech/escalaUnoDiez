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

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
        Schema::create('acceso_role', function (Blueprint $table) {
            $table->unsignedBigInteger('acceso_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('acceso_id')->references('id')->on('acceso')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->primary(['acceso_id', 'role_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('acceso_role');
        Schema::dropIfExists('acceso');
    }
}
