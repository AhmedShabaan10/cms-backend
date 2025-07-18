<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@admin.com')->first();
        if (is_null($admin)) {
            User::create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make(123456),
                'is_super_admin' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::where('email', 'user@admin.com')->first();
        if (is_null($user)) {
            $user = User::create([
                'name' => 'User',
                'email' => 'user@admin.com',
                'password' => Hash::make(123456),
                'is_super_admin' => 0,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $role_id = Role::where('name','admin')->get('id');
            $user->roles()->sync($role_id);
        }
    }

}
