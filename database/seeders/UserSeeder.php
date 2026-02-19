<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        User::create([
            'name' => 'Admin Restoranku',
            'email' => 'admin@restoranku.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);
    }
}