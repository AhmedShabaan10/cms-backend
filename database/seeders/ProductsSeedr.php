<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeedr extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        db::table('products')->truncate();
        $products = [
            [
                'name' => 'Vitamin C Serum',
                'description' => 'Brightening serum for skin.',
                'category_id' => 1,
                'price' => 19.99,
                'stock_quantity' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pain Relief Tablets',
                'description' => 'Fast acting pain relief.',
                'category_id' => 2,
                'price' => 7.99,
                'stock_quantity' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Omega 3 Capsules',
                'description' => 'Supports heart and brain health.',
                'category_id' => 3,
                'price' => 25.50,
                'stock_quantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Baby Lotion',
                'description' => 'Gentle moisturizing lotion for babies.',
                'category_id' => 4,
                'price' => 12.00,
                'stock_quantity' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SPF 50 Sunscreen',
                'description' => 'Water-resistant sun protection.',
                'category_id' => 1,
                'price' => 18.75,
                'stock_quantity' => 45,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Multivitamin Gummies',
                'description' => 'Daily multivitamins for adults.',
                'category_id' => 3,
                'price' => 15.90,
                'stock_quantity' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lip Balm',
                'description' => 'Moisturizing lip protection.',
                'category_id' => 1,
                'price' => 5.50,
                'stock_quantity' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kids Vitamin D Drops',
                'description' => 'Supports bone growth for kids.',
                'category_id' => 4,
                'price' => 9.99,
                'stock_quantity' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Muscle Recovery Powder',
                'description' => 'Post-workout recovery supplement.',
                'category_id' => 3,
                'price' => 29.99,
                'stock_quantity' => 55,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->updateOrInsert(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
