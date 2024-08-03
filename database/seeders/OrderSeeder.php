<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['pembayaran', 'proses', 'pengiriman'];
        $orders = [];

        for ($i = 1; $i <= 100; $i++) {
            $orders[] = [
                'order_number' => 'ORD-' . $i,
                'user_id' => rand(1, 2), // Ensure these IDs exist in the users table
                'total_price' => rand(50000, 150000),
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('order')->insert($orders);
    }
}
