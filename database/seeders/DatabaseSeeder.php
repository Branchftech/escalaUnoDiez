<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            'password' => bcrypt('Aa123456789'),
        ]);
        $permisosPrefix = ['ver', 'editar', 'eliminar', 'crear'];
        $permisos = ['permiso','rol','usuario'];

        $roles = [ 'Permisos',  'Roles', 'Usuarios', 'Administrador'];

        for ($f = 0; $f < 3; $f++) {
            $rol = new Role();
            $rol->name = $roles[$f];
            $rol->guard_name = 'web';
            $rol->save();
            for ($i = 0; $i < 4; $i++) {
                $permiso = new Permission();
                $permiso->name = $permisosPrefix[$i].'-'.$permisos[$f];
                $permiso->guard_name = 'web';
                $permiso->save();
                $rol->permissions()->attach($permiso->id);
            }
        }

        $roles = Role::all();
        foreach ($roles as $rol) {
            $admin->assignRole($rol->id);
        }

    }
}
