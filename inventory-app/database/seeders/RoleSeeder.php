<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'Admin',
                'created_at' => '2026-07-05 06:43:53',
                'updated_at' => '2026-07-05 06:43:53',
            ],
            [
                'id' => 2,
                'name' => 'Staff',
                'created_at' => '2026-07-05 06:43:53',
                'updated_at' => '2026-07-05 06:43:53',
            ],
            [
                'id' => 3,
                'name' => 'Manager',
                'created_at' => '2026-07-05 06:43:53',
                'updated_at' => '2026-07-05 06:43:53',
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(['id' => $role['id']], $role);
        }
    }
}
