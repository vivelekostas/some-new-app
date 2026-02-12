<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    protected string $guard = 'sanctum';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin', 'guard_name' => $this->guard]);
        Role::create(['name' => 'editor', 'guard_name' => $this->guard]);
        Role::create(['name' => 'writer', 'guard_name' => $this->guard]);
        Role::create(['name' => 'reader', 'guard_name' => $this->guard]);
    }
}
