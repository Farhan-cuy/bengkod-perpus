<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = ['admin', 'pustakawan', 'member'];

        foreach ($permissions as $permissionName) {
            Permission::findOrCreate($permissionName, 'web');
        }

        $adminRole = Role::findOrCreate('admin', 'web');
        $pustakawanRole = Role::findOrCreate('pustakawan', 'web');
        $memberRole = Role::findOrCreate('member', 'web');

        $adminRole->syncPermissions($permissions);
        $pustakawanRole->syncPermissions(['pustakawan']);
        $memberRole->syncPermissions(['member']);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
