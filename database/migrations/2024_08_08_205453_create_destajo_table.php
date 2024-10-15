<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestajoTable extends Migration
{
    public function up()
    {
        Schema::create('destajo', function (Blueprint $table) {
            $table->id();
            $table->decimal('presupuesto', 10, 2);
            $table->unsignedBigInteger('idObra');
            $table->foreign('idObra')->references('id')->on('obra');
            $table->unsignedBigInteger('idCliente');
            $table->foreignId('idProveedor')->constrained('proveedores');
            $table->unsignedBigInteger('idServicio');
            $table->foreign('idServicio')->references('id')->on('servicio');
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
        Schema::dropIfExists('destajo');
    }
}
