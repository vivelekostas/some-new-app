<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаём админа и двух тестовых юзеров
        $this->call(UserSeeder::class);

        // Создаём категории
        $categories = Category::factory()->count(5)->create();

        // Создаём пользователей
        $users = User::factory()->count(10)->create();

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
