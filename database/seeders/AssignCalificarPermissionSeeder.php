<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignCalificarPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear el permiso "calificar" si no existe
        $permission = Permission::firstOrCreate(['name' => 'calificar']);

        // Roles que deben tener el permiso "calificar"
        $roles = ['Docente', 'Administrador'];

        foreach ($roles as $roleName) {
            // Obtener o crear el rol
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Asignar el permiso al rol
            if (!$role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }
        }

        $this->command->info('Permiso "calificar" asignado a los roles Docente y Administrador.');
    }
}
