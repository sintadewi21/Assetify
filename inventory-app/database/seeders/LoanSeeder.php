<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $borrowings = [
            [
                'id' => 1,
                'user_id' => 1,
                'borrower_name' => 'sinta cakep',
                'borrow_date' => '2026-07-08',
                'due_date' => '2026-07-15',
                'return_date' => '2026-07-08',
                'status' => 'Returned',
                'reject_reason' => null,
                'created_at' => '2026-07-08 03:23:31',
                'updated_at' => '2026-07-08 05:47:03',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'borrower_name' => 'Sinta mode admin',
                'borrow_date' => '2026-05-08',
                'due_date' => '2026-06-15',
                'return_date' => null,
                'status' => 'Rejected',
                'reject_reason' => 'Loan cancelled due to being overdue.',
                'created_at' => '2026-07-08 05:47:45',
                'updated_at' => '2026-07-08 05:58:00',
            ],
        ];

        foreach ($borrowings as $borrowing) {
            DB::table('borrowings')->updateOrInsert(['id' => $borrowing['id']], $borrowing);
        }
    }
}
