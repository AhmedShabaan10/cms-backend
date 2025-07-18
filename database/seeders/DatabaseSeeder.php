<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Create roles and permissions
        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(ProductsSeedr::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(OrderSeeder::class);


        
    }
}
