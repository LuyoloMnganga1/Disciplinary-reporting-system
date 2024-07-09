<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Luyolo Mnganga',
            'email' => 'luyolo.mnganga@ictchoice.co.za',
            'password' => Hash::make('password')
        ]);
        User::create([
            'name' => 'Ayabonga Maqashu',
            'email' => 'ayabonga.maqashu@ictchoice.co.za',
            'password' => Hash::make('password')
        ]);
    }
}
