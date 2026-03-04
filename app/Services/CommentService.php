<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\CommentCreatedEvent;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
    /**
     * @param User $user
     * @return LengthAwarePaginator
     */
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

    /**
     * @param User $user
     * @return LengthAwarePaginator
     */
    public function getLiked(User $user): LengthAwarePaginator
    {
        return $user->likedComments()->latest()->paginate();
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Comment::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Создаёт новый комментарий к посту. После успешного создания комментария
     * диспатчит событие, если автор комментария не совпадает с автором поста.
     *
     * @param Post $post
     * @param array $data
     * @param int $user_id
     * @return Comment
     */
    public function create(Post $post, array $data, int $user_id): Comment
    {
        $comment = $post->comments()->create([
            ...$data,
            'user_id' => $user_id,
        ]);

        if ($post->shouldNotifyAboutCommentFrom($user_id)) {
            CommentCreatedEvent::dispatch($comment);
        }

        return $comment;
    }

    /**
     * @param Comment $comment
     * @param array $data
     * @return Comment
     */
    public function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);

        return $comment->refresh();
    }

    /**
     * @param Comment $comment
     * @return void
     */
    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
