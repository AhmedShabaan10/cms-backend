<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view-dashboard',

            'roles-list',
            'roles-view',
            'roles-create',
            'roles-update',
            'roles-delete',

            'users-list',
            'users-view',
            'users-create',
            'users-update',
            'users-delete',
            
            'product-list',
            'product-view',
            'product-create',
            'product-update',
            'product-delete',

            'category-list',
            'category-view',
            'category-create',
            'category-update',
            'category-delete',

            'view-orders',
            'show-orders',
            'update-orders',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
