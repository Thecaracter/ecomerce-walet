<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderDetails = [];

        for ($i = 1; $i <= 100; $i++) {
            $orderDetails[] = [
                'order_id' => $i, // Ensure these IDs exist in the orders table
                'product_id' => rand(1, 2), // Ensure these IDs exist in the products table
                'qty' => rand(1, 5),
                'price' => rand(10000, 50000),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('order_detail')->insert($orderDetails);
    }
}
