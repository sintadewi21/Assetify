<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'role' => 'admin',
                'name' => 'Admin1',
                'email' => 'admin1@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$c440FGwL5wp8AoOZdhFOvufiTuwX1gAz.bha0bo5ZF3tbBSQ1QK.i',
                'remember_token' => null,
                'created_at' => '2026-07-05 06:43:54',
                'updated_at' => '2026-07-05 06:43:54',
            ],
            [
                'id' => 2,
                'role' => 'admin',
                'name' => 'Admin2',
                'email' => 'admin2@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$kyYvBNhyJmUtChmzseRKA.Pok8Iaa0m9QWCW3RQeSBAa.eDSPuN.q',
                'remember_token' => null,
                'created_at' => '2026-07-05 06:43:54',
                'updated_at' => '2026-07-05 06:43:54',
            ],
            [
                'id' => 3,
                'role' => 'admin',
                'name' => 'Admin3',
                'email' => 'admin3@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$Mvt2wQeue.UDYE/VFINFlOXamIyZZIe53IjtH5nBxz0GE06p9sdZ6',
                'remember_token' => null,
                'created_at' => '2026-07-05 06:43:55',
                'updated_at' => '2026-07-05 06:43:55',
            ],
            [
                'id' => 4,
                'role' => 'staff',
                'name' => 'Staff Inventory',
                'email' => 'staff@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$cRpQGzkLWxgqv5lTLxrFp.D40jaXuhAoNa/M5HIkGtniK0QWAJtTy',
                'remember_token' => null,
                'created_at' => '2026-07-05 06:43:55',
                'updated_at' => '2026-07-05 06:43:55',
            ],
            [
                'id' => 5,
                'role' => 'manager',
                'name' => 'Manager Inventory',
                'email' => 'manager@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$yxT94A8nObl7LHwgjkwdruN2Jar8GJUGm8hH5vCpjQ4qDF8IqtKU6',
                'remember_token' => null,
                'created_at' => '2026-07-05 06:43:56',
                'updated_at' => '2026-07-05 06:43:56',
            ],
            [
                'id' => 6,
                'role' => 'staff',
                'name' => 'sinta cakep',
                'email' => 'sinta1@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$DP6UuDhZoXR1PyVNXOFVXezeiOEgbpepWjl5TUpp.BZcyA4kuIoou',
                'remember_token' => 'XV5PFsNuhMmAk1OQy9WniaanDb19u1Du3sjhvORLUBwuZ6uLlJIW5JoSPxal',
                'created_at' => '2026-07-07 21:50:00',
                'updated_at' => '2026-07-07 22:03:16',
            ],
            [
                'id' => 7,
                'role' => 'staff',
                'name' => 'sinta cakep banget',
                'email' => 'sintacakep@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$fE4Zw2kon5VaqOBiCTXFUeRIjpGg6tRwt05GVUx8iKmWoCM7JJdZy',
                'remember_token' => null,
                'created_at' => '2026-07-07 22:05:15',
                'updated_at' => '2026-07-07 22:05:15',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(['id' => $user['id']], $user);
        }
    }
}
