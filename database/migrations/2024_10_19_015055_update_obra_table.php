
        <?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateObraTable extends Migration
{
    public function up()
    {
        Schema::table('obra', function (Blueprint $table) {
            // Cambiar los campos para que sean nullable

        $table->string('contrato', 100)->nullable()->change();
        $table->string('licenciaConstruccion', 100)->nullable()->change();
        });
    }

    public function down()
{
    Schema::table('obra', function (Blueprint $table) {
        // Revertir los cambios
        $table->string('contrato', 100)->nullable(false)->change();
        $table->string('licenciaConstruccion', 100)->nullable(false)->change();
    });
}
}
