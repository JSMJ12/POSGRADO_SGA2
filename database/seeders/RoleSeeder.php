<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $role1 = Role::create(['name' => 'Administrador']);
            $role2 = Role::create(['name' => 'Docente']);
            $role3 = Role::create(['name' => 'Secretario']);
            $role4 = Role::create(['name' => 'Alumno']);
            $role5 = Role::create(['name' => 'Postulante']);
            //Administrador
            $permission1 = Permission::create(['name' => 'dashboard_admin'])->syncRoles([$role1]);
            $permission2 = Permission::create(['name' => 'admin.usuarios.disable'])->syncRoles([$role1]);
            $permission3 = Permission::create(['name' => 'admin.usuarios.enable'])->syncRoles([$role1]);
            $permissionA = Permission::create(['name' => 'admin.usuarios.crear'])->syncRoles([$role1]);
            $permissionb = Permission::create(['name' => 'admin.usuarios.editar'])->syncRoles([$role1]);
            $permissionc = Permission::create(['name' => 'admin.usuarios.listar'])->syncRoles([$role1]);
    
            //Secretario
            $permission1 = Permission::create(['name' => 'dashboard_secretario'])->syncRoles([$role1,$role3 ]);
            $permissionA1 = Permission::create(['name' => 'secretarios.crear'])->syncRoles([$role1, $role3]);
            $permissionb1 = Permission::create(['name' => 'secretarios.editar'])->syncRoles([$role1, $role3]);
            $permissionc2 = Permission::create(['name' => 'secretarios.listar'])->syncRoles([$role1, $role3]);
            $permission7 = Permission::create(['name' => 'docentes.crear'])->syncRoles([$role1, $role3]);
            $permission8 = Permission::create(['name' => 'docentes.editar'])->syncRoles([$role1, $role3]);
            $permission9 = Permission::create(['name' => 'docentes.listar'])->syncRoles([$role1, $role3]);
            $permission10 = Permission::create(['name' => 'paralelo.crear'])->syncRoles([$role1, $role3]);
            $permission11 = Permission::create(['name' => 'paralelo.eliminar'])->syncRoles([$role1, $role3]);
            $permission12 = Permission::create(['name' => 'paralelo.editar'])->syncRoles([$role1, $role3]);
            $permission13 = Permission::create(['name' => 'paralelo.listar'])->syncRoles([$role1, $role3]);
    
            //Docente
            $permission1 = Permission::create(['name' => 'dashboard_docente'])->syncRoles([$role1,$role2 ]);
    
            //Alumno
            $permission1 = Permission::create(['name' => 'dashboard_alumno'])->syncRoles([$role1,$role4 ]);
    
            //Postulante
            $permission1 = Permission::create(['name' => 'dashboard_postulante'])->syncRoles([$role5, $role1 ]);
        }
    }
}
