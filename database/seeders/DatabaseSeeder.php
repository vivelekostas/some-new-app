<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаём permissions
        $this->call(PermissionSeeder::class);
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Создаём роли
        $this->call(RoleSeeder::class);

        $adminRole = Role::findByName('admin', 'sanctum');
        $editorRole = Role::findByName('editor', 'sanctum');
        $writerRole = Role::findByName('writer', 'sanctum');
        $readerRole = Role::findByName('reader', 'sanctum');

        // Привязываем permissions к ролям.
        $adminRole->givePermissionTo([
            'create posts',
            'edit posts',
            'view posts',
            'delete posts',
        ]);
        $editorRole->givePermissionTo([
            'view posts',
            'edit posts',
        ]);
        $writerRole->givePermissionTo([
            'create posts',
            'edit posts',
            'view posts',
            'delete posts',
        ]);
        $readerRole->givePermissionTo([
            'view posts',
        ]);

        // Создаём админа, редактора, юзера.
        $this->call(UserSeeder::class);

        // Присваиваем соответствующие роли пользователям.
        $admin = User::query()->find(1);
        $admin->assignRole('admin');

        $editor = User::query()->find(2);
        $editor->assignRole('editor');

        $writer = User::query()->find(3);
        $writer->assignRole('writer');

        $reader = User::query()->find(4);
        $reader->assignRole('reader');

        // Создаём категории
        $categories = Category::factory()->count(5)->create();

        // Создаём пользователей
        $users = User::factory()->count(10)->writer()->create();

        // Каждый пользователь создаёт 10 своих постов
        foreach ($users as $user) {
            Post::factory()
                ->count(10)
                ->for($user)
                ->for($categories->random())
                ->create();
        }

        $allPosts = Post::all();

        // Каждый пользователь комментирует 10 чужих постов
        foreach ($users as $user) {

            $foreignPosts = $allPosts
                ->where('user_id', '!=', $user->id)
                ->shuffle()
                ->take(10);

            foreach ($foreignPosts as $post) {
                Comment::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}
