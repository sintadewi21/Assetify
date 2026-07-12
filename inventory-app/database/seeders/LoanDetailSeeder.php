<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $details = [
            [
                'id' => 1,
                'borrowing_id' => 1,
                'product_id' => 10,
                'qty' => 1,
                'created_at' => '2026-07-08 03:23:31',
                'updated_at' => '2026-07-08 03:23:31',
            ],
            [
                'id' => 2,
                'borrowing_id' => 2,
                'product_id' => 11,
                'qty' => 1,
                'created_at' => '2026-07-08 05:47:45',
                'updated_at' => '2026-07-08 05:47:45',
            ],
            [
                'id' => 3,
                'borrowing_id' => 2,
                'product_id' => 3,
                'qty' => 1,
                'created_at' => '2026-07-08 05:47:45',
                'updated_at' => '2026-07-08 05:47:45',
            ],
        ];

        foreach ($details as $detail) {
            DB::table('borrowing_details')->updateOrInsert(['id' => $detail['id']], $detail);
        }
    }
}
