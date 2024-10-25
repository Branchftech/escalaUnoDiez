<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Roles;
use App\Models\Acceso;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456789'), //Aa123456789
        ]);


        Roles::create(['nombre' => 'Admin']);
        Roles::create(['nombre' => 'User']);

        $adminRole = Roles::where('nombre', 'Admin')->first();
        $userRole = Roles::where('nombre', 'User')->first();
        // Asignar el rol 'Admin' al usuario administrador
        $admin->roles()->attach($adminRole->id);
        // Crea accesos y asigna rol correspondiente
        Acceso::create([
            'nombre' => 'Dashboard',
            'url' => 'dashboard',
            'icono' => 'fas fa-home',

        ]);

        Acceso::create([
            'nombre' => 'Bancos',
            'url' => 'bancos',
            'icono' => 'fa-solid fa-building-columns',

        ]);

        Acceso::create([
            'nombre' => 'Proveedores',
            'url' => 'proveedores',
            'icono' => 'fa-solid fa-user-tie',

        ]);

        Acceso::create([
            'nombre' => 'Clientes',
            'url' => 'clientes',
            'icono' => 'fa-solid fa-user-plus',

        ]);

        Acceso::create([
            'nombre' => 'Formas Pago',
            'url' => 'formasPago',
            'icono' => 'fa-solid fa-cash-register',

        ]);

        Acceso::create([
            'nombre' => 'Insumos',
            'url' => 'insumos',
            'icono' => 'fa-solid fa-person-digging',

        ]);

        Acceso::create([
            'nombre' => 'Obras',
            'url' => 'obras',
            'icono' => 'fa-solid fa-building-user',

        ]);

        Acceso::create([
            'nombre' => 'Egresos',
            'url' => 'egresos',
            'icono' => 'fa-solid fa-money-bill-transfer',

        ]);

        Acceso::create([
            'nombre' => 'Ingresos',
            'url' => 'ingresos',
            'icono' => 'fa-solid fa-money-bill-trend-up',

        ]);

        Acceso::create([
            'nombre' => 'Destajos',
            'url' => 'destajos',
            'icono' => 'fa-solid fa-handshake-simple',

        ]);
    }
}
