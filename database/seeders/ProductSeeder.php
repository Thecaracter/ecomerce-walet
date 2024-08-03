<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product')->insert([
            [
                'name' => 'Product 1',
                'description' => 'Description for Product 1',
                'price' => 100.00,
                'stock' => 10,
                'foto' => 'product1.jpeg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for Product 2',
                'price' => 200.00,
                'stock' => 20,
                'foto' => 'product2.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more products as needed
        ]);
    }
}
