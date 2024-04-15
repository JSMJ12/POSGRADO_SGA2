<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignCalificarPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener el permiso "calificar"
        $permission = Permission::where('name', 'calificar')->first();

        if (!$permission) {
            // Crear el permiso si no existe
            $permission = Permission::create(['name' => 'calificar']);
        }

        // Obtener el rol "docente"
        $docenteRole = Role::where('name', 'Docente')->first();

        // Asignar el permiso "calificar" a todos los usuarios con el rol "docente"
        $docentes = User::role('Docente')->get();
        foreach ($docentes as $docente) {
            $docente->givePermissionTo($permission);
        }
        $admins = User::role('Administrador')->get();
        foreach ($admins as $admin) {
            $admin->givePermissionTo($permission);
        }
    }
}
