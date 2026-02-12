<?php

declare(strict_types=1);

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

        User::factory()->create([
            'name' => 'editor',
            'email' => 'editor@editor.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty'),
        ]);

        User::factory()->hasPosts(2, [
            'is_published' => true
        ])->create([
            'name' => 'writer',
            'email' => 'writer@writer.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty'),
        ]);

        User::factory()->create([
            'name' => 'reader',
            'email' => 'reader@reader.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty'),
        ]);
    }
}
