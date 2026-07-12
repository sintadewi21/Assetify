<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $notifications = [
            [
                'id' => 1,
                'user_id' => 5,
                'title' => 'New Loan Request',
                'message' => 'Staff "Admin1" requested a loan for "sinta cakep".',
                'is_read' => 0,
                'created_at' => '2026-07-08 03:23:31',
                'updated_at' => '2026-07-08 03:23:31',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'title' => 'Loan Request Approved',
                'message' => 'Your loan request for "sinta cakep" has been approved!',
                'is_read' => 0,
                'created_at' => '2026-07-08 05:46:57',
                'updated_at' => '2026-07-08 05:46:57',
            ],
            [
                'id' => 3,
                'user_id' => 5,
                'title' => 'New Loan Request',
                'message' => 'Staff "Admin1" requested a loan for "Sinta mode admin".',
                'is_read' => 0,
                'created_at' => '2026-07-08 05:47:45',
                'updated_at' => '2026-07-08 05:47:45',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'title' => 'Loan Request Approved',
                'message' => 'Your loan request for "Sinta mode admin" has been approved!',
                'is_read' => 0,
                'created_at' => '2026-07-08 05:47:48',
                'updated_at' => '2026-07-08 05:47:48',
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'title' => 'Overdue Return Warning',
                'message' => 'Please contact borrower "Sinta mode admin" immediately. The loan for items (due on 15 Jun 2026) is overdue.',
                'is_read' => 0,
                'created_at' => '2026-07-08 05:48:00',
                'updated_at' => '2026-07-08 05:48:00',
            ],
        ];

        foreach ($notifications as $notification) {
            DB::table('notifications')->updateOrInsert(['id' => $notification['id']], $notification);
        }
    }
}
