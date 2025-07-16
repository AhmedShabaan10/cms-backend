<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Cosmetics',
            'Over-the-counter',
            'Supplements',
            'Personal Care',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
            ['name' => $category],
            ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
