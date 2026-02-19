<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Просмотр списка постов
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view posts');
    }

    /**
     * Просмотр конкретного поста
     */
    public function view(User $user, Post $post): bool
    {
        return $user->can('view posts');
    }

    /**
     * Создание поста
     */
    public function create(User $user): bool
    {
        return $user->can('create posts');
    }

    /**
     * Обновление поста
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->can('edit any posts')) {
            return true;
        }

        return $user->can('edit own posts')
            && $user->id === $post->user_id;
    }

    /**
     * Удаление поста
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->can('delete any posts')) {
            return true;
        }

        return $user->can('delete own posts')
            && $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
