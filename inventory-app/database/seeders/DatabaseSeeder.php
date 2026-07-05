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
        $adminRole = Role::create(['name' => 'Admin']);
        $staffRole = Role::create(['name' => 'Staff']);
        $managerRole = Role::create(['name' => 'Manager']);

        // 2. Buat Akun Login Testing
        // 3 Admin Accounts
        User::create([
            'name' => 'Admin1',
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Admin2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Admin3',
            'email' => 'admin3@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // 1 Staff Account
        User::create([
            'name' => 'Staff Inventory',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('staff123'),
            'role' => 'staff',
        ]);

        // 1 Manager Account
        User::create([
            'name' => 'Manager Inventory',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('manager123'),
            'role' => 'manager',
        ]);
    }
}
