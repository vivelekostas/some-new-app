<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    public function getPublicPosts(): LengthAwarePaginator
    {
        return Post::query()
            ->whereIsPublished(true)
            ->latest()
            ->paginate();
    }

    public function getForDashboard(User $user): LengthAwarePaginator
    {
        return match (true) {
            $user->hasRole('admin'),
            $user->hasRole('editor') =>
            Post::query()->whereIsPublished(true)
                ->latest()
                ->paginate(),

            $user->hasRole('writer') =>
            Post::query()->whereUserId($user->id)
                ->latest()
                ->paginate(),

            $user->hasRole('reader') =>
            $user->likedPosts()
//                ->whereIsPublished('true')
                ->latest()
                ->paginate(),

            default => Post::query()->whereRaw('1 = 0')->paginate(),
        };
    }

    public function getLiked(User $user): LengthAwarePaginator
    {
        return $user->likedPosts()->latest()->paginate();
    }

    public function paginate(): LengthAwarePaginator
    {
        return Post::query()
            ->latest()
            ->paginate();
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
