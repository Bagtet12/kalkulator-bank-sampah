<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('test'),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@bank.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
    }
}
