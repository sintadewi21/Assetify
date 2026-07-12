<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Elektronik',
                'created_at' => '2026-07-05 13:45:50',
                'updated_at' => '2026-07-05 13:45:50',
            ],
            [
                'id' => 2,
                'name' => 'Alat Tulis Kantor (ATK)',
                'created_at' => '2026-07-05 13:45:50',
                'updated_at' => '2026-07-05 13:45:50',
            ],
            [
                'id' => 3,
                'name' => 'Fasilitas Ruangan',
                'created_at' => '2026-07-05 13:45:50',
                'updated_at' => '2026-07-05 13:45:50',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(['id' => $category['id']], $category);
        }
    }
}
