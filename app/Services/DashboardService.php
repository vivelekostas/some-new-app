<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\PostCollection;
use App\Models\User;

class DashboardService
{
    public function __construct(
        protected PostService     $postService,
        protected CommentService  $commentService,
        protected CategoryService $categoryService,
    )
    {
    }

    /**
     *  Формирует агрегированные данные для дашборда пользователя.
     *
     *  В зависимости от роли пользователя сервис собирает релевантные данные:
     *  - категории (только админ);
     *  - посты (все опубликованные или только свои);
     *  - комментарии (по той же логике);
     *  - отдельно лайкнутые посты и комментарии.
     *
     *  Каждый вложенный сервис самостоятельно определяет ограничения
     *  доступа и бизнес-логику выборки данных на основе политик и ролей.
     *
     * @param User $user
     * @return array{
     * role: string|null,
     * data: array{
     * categories: CategoryCollection,
     * posts: PostCollection,
     * comments: CommentCollection,
     * liked_posts: PostCollection,
     * liked_comments: CommentCollection
     * }
     * }
     */
    public function handle(User $user): array
    {
        return [
            'role' => $user->getRoleNames()->first(),

            'data' => [
                'categories' => new CategoryCollection(
                    $this->categoryService->getForDashboard($user)
                ),

                'posts' => new PostCollection(
                    $this->postService->getForDashboard($user)
                ),

                'comments' => new CommentCollection(
                    $this->commentService->getForDashboard($user)
                ),

                'liked_posts' => new PostCollection(
                    $this->postService->getLiked($user)
                ),

                'liked_comments' => new CommentCollection(
                    $this->commentService->getLiked($user)
                ),
            ],
        ];
    }
}
