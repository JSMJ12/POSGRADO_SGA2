<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionepsuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crear el permiso epsu_dashboard
        $permission = Permission::create(['name' => 'epsu_dashboard']);

        // Crear el rol secretario_epsu y asignarle el permiso epsu_dashboard
        $role = Role::create(['name' => 'secretario_epsu']);
        $role->givePermissionTo($permission);
    }
}
