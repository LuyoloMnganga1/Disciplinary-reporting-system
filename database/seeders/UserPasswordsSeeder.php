<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserPasswords;
use Illuminate\Support\Facades\Hash;

class UserPasswordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserPasswords::create([
            'user_id' => 1,
            'password' => Hash::make('password')
        ]);
        UserPasswords::create([
            'user_id' => 1,
            'password' => Hash::make('password')
        ]);
    }
}
