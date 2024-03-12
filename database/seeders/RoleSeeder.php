<?php

namespace Database\Seeders;

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
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'cliente']);

        $permission = Permission::create(['name' => 'admin'])->syncRoles(['admin']);
        $permission = Permission::create(['name' => 'cliente'])->syncRoles([$role1,$role2]);
    }
}
