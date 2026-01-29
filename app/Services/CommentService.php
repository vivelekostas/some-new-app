<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
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
