<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
    public function getForDashboard(User $user): LengthAwarePaginator
    {
        return match (true) {
            $user->hasRole('admin'),
            $user->hasRole('editor') =>
            Comment::query()->latest()
                ->paginate(),

            $user->hasRole('writer') =>
            Comment::query()->whereUserId($user->id)
                ->latest()
                ->paginate(),

            $user->hasRole('reader') =>
            $user->likedComments()
                ->latest()
                ->paginate(),

            default => Post::query()->whereRaw('1 = 0')->paginate(),
        };
    }

    public function getLiked(User $user): LengthAwarePaginator
    {
        return $user->likedComments()->latest()->paginate();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Comment::query()
            ->latest()
            ->paginate($perPage);
    }

    public function create(Post $post, array $data, int $user_id): Comment
    {
        return $post->comments()->create([
            ...$data,
            'user_id' => $user_id,
        ]);
    }

    public function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);

        return $comment->refresh();
    }

    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
