<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PostLanterolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleName = 'Postulante';
        $permissionName = 'dashboard_postulante';

        // Buscar el permiso
        $permission = Permission::where('name', $permissionName)->first();

        // Si el permiso no existe, crea el permiso
        if (!$permission) {
            $permission = Permission::create(['name' => $permissionName]);
        }

        // Buscar o crear el rol
        $role = Role::firstOrCreate(['name' => $roleName]);

        // Asignar el permiso al rol si no está asignado
        if (!$role->hasPermissionTo($permissionName)) {
            $role->givePermissionTo($permissionName);
        }
        $role = Role::where('name', $roleName)->first();

// Verificar si el rol existe
        if ($role) {
            // Verificar si el rol tiene el permiso asignado
            if ($role->hasPermissionTo($permissionName)) {
                echo "El permiso '$permissionName' se asignó correctamente al rol '$roleName'.";
            } else {
                echo "El permiso '$permissionName' no se asignó al rol '$roleName'.";
            }
        } else {
            echo "El rol '$roleName' no existe.";
        }

    }

}
