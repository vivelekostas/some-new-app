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
        User::query()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty'),
        ]);

        User::factory()->hasPosts(2, [
            'is_published' => true
        ])->create([
            'name' => 'user',
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty'),
        ]);

        User::factory()->hasPosts(2, [
            'is_published' => true
        ])->create([
            'name' => 'userok',
            'email' => 'userok@user.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty'),
        ]);
    }
}
