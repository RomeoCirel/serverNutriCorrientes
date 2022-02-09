<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermisosAdministracionDeMarcas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            ['name' => 'acceso.adminsitracion.marcas'],
            ['name' => 'marcas.listado'],
            ['name' => 'marcas.crear'],
            ['name' => 'marcas.editar'],
            ['name' => 'marcas.show'],
            ['name' => 'marcas.eliminar'],
            ['name' => 'marcas.restaurar'],
        ];

        foreach ($permisos as $permiso) {
            Permission::create($permiso);
        }
    }
}
