<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'SuperAdmin'],
            ['name' => 'Jefe de Producción'],
            ['name' => 'Jefe de Personal'],
            ['name' => 'Jefe de Administración']
        ];

        foreach ($roles as $rol) {
            Role::create($rol);
        }
    }
}
