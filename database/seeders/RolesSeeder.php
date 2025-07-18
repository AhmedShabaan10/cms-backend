<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Has access to all features and settings.',
        ]);
        $admin->syncPermissions([
            
            'view-dashboard',

            //roles
            'roles-list',
            'roles-view',
            'roles-create',
            'roles-update',
            'roles-delete',

            //users
            'users-list',
            'users-view',
            'users-create',
            'users-update',
            'users-delete',

            //products
            'product-list',
            'product-view',
            'product-create',
            'product-update',
            'product-delete',

            //orders
            'orders-list',
            'orders-view',
            'orders-create',
            'orders-update',
        ]);

        $user = Role::firstOrCreate([
            'name' => 'user',
            'display_name' => 'Normal User',
            'description' => 'Can view products and orders.',
        ]);
        $user->syncPermissions([
            
            'view-dashboard',
            
            'orders-list',
            'orders-view',
            'orders-create',
            'orders-update',
        ]);

    }
}
