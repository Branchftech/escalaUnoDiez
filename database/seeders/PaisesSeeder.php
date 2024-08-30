<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar países
        $paises = [
            ['nombre' => 'EEUU'],
            ['nombre' => 'México'],
        ];

        DB::table('paises')->insert($paises);

        // Obtener los IDs de los países insertados
        $eeuuId = DB::table('paises')->where('nombre', 'EEUU')->first()->id;
        $mexicoId = DB::table('paises')->where('nombre', 'México')->first()->id;

        // Insertar estados para EEUU
        $estadosEEUU = [
            ['nombre' => 'California', 'idPais' => $eeuuId],
            ['nombre' => 'Texas', 'idPais' => $eeuuId],
            // Agrega más estados si lo deseas
        ];

        // Insertar estados para México
        $estadosMexico = [
            ['nombre' => 'Ciudad de México', 'idPais' => $mexicoId],
            ['nombre' => 'Jalisco', 'idPais' => $mexicoId],
            // Agrega más estados si lo deseas
        ];

        DB::table('estados')->insert($estadosEEUU);
        DB::table('estados')->insert($estadosMexico);
    }
}
