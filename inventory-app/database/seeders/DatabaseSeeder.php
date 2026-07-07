<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Buat Role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $staffRole = Role::firstOrCreate(['name' => 'Staff']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);

        // 2. Buat Akun Login Testing
        // 3 Admin Accounts
        User::firstOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Admin1',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin2@gmail.com'],
            [
                'name' => 'Admin2',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin3@gmail.com'],
            [
                'name' => 'Admin3',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        // 1 Staff Account
        User::firstOrCreate(
            ['email' => 'staff@gmail.com'],
            [
                'name' => 'Staff Inventory',
                'password' => bcrypt('staff123'),
                'role' => 'staff',
            ]
        );

        // 1 Manager Account
        User::firstOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'Manager Inventory',
                'password' => bcrypt('manager123'),
                'role' => 'manager',
            ]
        );
    }
}
