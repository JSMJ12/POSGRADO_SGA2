<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permisos necesarios para el rol Alumno
        $permissions = ['alumno_descuento', 'alumno_pago'];

        // Crear los permisos si no existen
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Busca el rol Alumno
        $role = Role::firstOrCreate(['name' => 'Alumno']);

        // Verifica si el rol Alumno existe
        if ($role) {
            // Obtén los permisos y asigna al rol
            $permissions = Permission::whereIn('name', $permissions)->get();
            $role->syncPermissions($permissions);

            $this->command->info('Se han asignado los permisos al rol Alumno.');
        } else {
            $this->command->error('El rol Alumno no ha sido encontrado.');
        }
    }
}
