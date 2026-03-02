<?php

declare(strict_types=1);

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
        // Посты.
        Permission::create(['name' => 'create posts', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'edit own posts', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'edit any posts', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'delete own posts', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'delete any posts', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'view posts', 'guard_name' => $this->guard]);

        // Комменты.
        Permission::create(['name' => 'create comments', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'edit own comments', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'edit any comments', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'delete own comments', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'delete any comments', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'view comments', 'guard_name' => $this->guard]);

        // Категории.
        Permission::create(['name' => 'create categories', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'edit categories', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'delete categories', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'view categories', 'guard_name' => $this->guard]);

        // Теги.
        Permission::create(['name' => 'create tags', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'edit tags', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'delete tags', 'guard_name' => $this->guard]);
        Permission::create(['name' => 'view tags', 'guard_name' => $this->guard]);
    }
}
