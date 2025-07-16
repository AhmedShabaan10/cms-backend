<?php

namespace Database\Seeders;

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
       $user = User::where('email','admin@admin.com')->first();
        if(is_null($user)){
            User::create([
                'name'=>'admin',
                'email'=>'admin@admin.com',
                'password'=>Hash::make(123456),
                'is_super_admin'=>1,
                'email_verified_at'=> now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
