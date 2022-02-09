<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermisosAdministracionDePersonal extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::wherein('name', ['Admin', 'SuperAdmin', 'Jefe de Personal'])->get();

        $permisos = [
            ['name' => 'acceso.gestion'],
            ['name' => 'acceso.adminsitracion.personal'],
            ['name' => 'personal.listado'],
            ['name' => 'personal.crear'],
            ['name' => 'personal.editar'],
            ['name' => 'personal.show'],
            ['name' => 'personal.eliminar'],
            ['name' => 'personal.restaurar'],
        ];

        foreach ($permisos as $permiso) {
            Permission::create($permiso)->syncRoles($roles);
        }
    }
}
