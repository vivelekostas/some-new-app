<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\PostPublishedEvent;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getPublicPosts(): LengthAwarePaginator
    {
        return Post::query()
            ->whereIsPublished(true)
            ->latest()
            ->paginate();
    }

    /**
     * @param User $user
     * @return LengthAwarePaginator
     */
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

    /**
     * @param User $user
     * @return LengthAwarePaginator
     */
    public function getLiked(User $user): LengthAwarePaginator
    {
        return $user->likedPosts()->latest()->paginate();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function paginate(): LengthAwarePaginator
    {
        return Post::query()
            ->latest()
            ->paginate();
    }

    /**
     * Создаёт новый пост. Если есть теги, то аттачит их к посту.
     * Если пост сразу публикуется, то выбрасываем соответсвующее событие.
     *
     * @param User $user
     * @param array $data
     * @return Post
     */
    public function create(User $user, array $data): Post
    {
        $post = $user->posts()->create($data);

        if (!empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        if ($post->is_published) {
            PostPublishedEvent::dispatch($post);
        }

        return $post;
    }

    /**
     * Обновляет пост. Если есть теги, то аттачит их к посту.
     * Если пост публикуется из черновика, то выбрасываем соответсвующее событие.
     *
     * @param Post $post
     * @param array $data
     * @return Post
     */
    public function update(Post $post, array $data): Post
    {
        $wasPublished = $post->is_published;

        $post->update($data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        if (!$wasPublished && $post->is_published) {
            PostPublishedEvent::dispatch($post);
        }

        return $post->refresh();
    }

    /**
     * @param Post $post
     * @return void
     */
    public function delete(Post $post): void
    {
        $post->delete();
    }
}
