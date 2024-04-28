<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crear el rol "Coordinador"
        $coordinadorRole = Role::create(['name' => 'Coordinador']);

        // Crear el permiso "dashboard_coordinador"
        $dashboardCoordinadorPermission = Permission::create(['name' => 'dashboard_coordinador']);

        // Asignar el permiso "dashboard_coordinador" al rol "Coordinador"
        $coordinadorRole->givePermissionTo($dashboardCoordinadorPermission);
    }

}
