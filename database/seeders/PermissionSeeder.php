<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    protected string $guard = 'sanctum';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create posts', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'edit posts', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'view posts', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'delete posts', 'guard_name' => $this->guard]);
    }
}
