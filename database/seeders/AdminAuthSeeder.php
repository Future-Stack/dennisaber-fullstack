<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'dennis@besseler.de',
            ],
            [
            'name' => 'Dennis',
            'password' => Hash::make('password123'),
            'security_code_hash' => Hash::make('1234'),
        ]);
    }
}
