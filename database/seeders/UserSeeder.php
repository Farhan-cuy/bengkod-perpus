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
        // Pastikan role sudah ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Buat user
        $user = User::create([
            'name' => 'Admin',
            'email' => 'Farhan@example.com',
            'password' => bcrypt('12345'), // password
        ]);

        // Assign role ke user
        $user->assignRole($adminRole);
    }
}
