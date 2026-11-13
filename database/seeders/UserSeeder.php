<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seeded Resident User
        User::create([
            'name'     => 'Lola Flores',
            'email'    => 'lola.flores@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        // 2. Seeded Kagawad User & link to existing Kagawad Author profile
        $kagawadUser = User::create([
            'name'     => 'Kagawad Kauri Lorraine Flores',
            'email'    => 'kagawad.flores@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        $kagawadAuthor = Author::where('email', 'kagawad.flores@bulletin.test')->first();
        if ($kagawadAuthor) {
            $kagawadAuthor->update(['user_id' => $kagawadUser->id]);
        }

        // 3. 8 additional factory resident users
        User::factory()->count(8)->create();
    }
}