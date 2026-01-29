<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Post::query()
            ->latest()
            ->paginate($perPage);
    }

    public function create(User $user, array $data): Post
    {
        return $user->posts()->create($data);
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);

        return $post->refresh();
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }
}
