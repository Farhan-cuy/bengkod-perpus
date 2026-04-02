<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $pustakawanRole = Role::firstOrCreate(['name' => 'pustakawan', 'guard_name' => 'web']);
        $memberRole = Role::firstOrCreate(['name' => 'member', 'guard_name' => 'web']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('12345'),
            ]
        );

        $pustakawan = User::updateOrCreate(
            ['email' => 'pustakawan@gmail.com'],
            [
                'name' => 'Pustakawan',
                'password' => bcrypt('12345'),
            ]
        );

        $member = User::updateOrCreate(
            ['email' => 'member@gmail.com'],
            [
                'name' => 'Member',
                'password' => bcrypt('12345'),
            ]
        );

        $admin->syncRoles([$adminRole]);
        $pustakawan->syncRoles([$pustakawanRole]);
        $member->syncRoles([$memberRole]);
    }
}
