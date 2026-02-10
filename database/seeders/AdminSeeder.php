<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        if (!$admin) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => null, // password will be set later
            ]);
        }
    }
}
