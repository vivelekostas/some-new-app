<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Подписывает текущего пользователя на автора.
     *
     * @param Request $request
     * @param User $author
     * @return JsonResponse
     */
    public function store(Request $request, User $author): JsonResponse
    {
        $user = $request->user();

        // Нельзя подписаться на самого себя
        if ($user->id === $author->id) {
            return response()->json([
                'message' => 'You cannot subscribe to yourself.'
            ], 422);
        }

        $user->subscriptions()->syncWithoutDetaching($author->id);

        return response()->json([
            'message' => 'Subscribed successfully.'
        ]);
    }

    /**
     * Отписывает текущего пользователя от автора.
     *
     * @param Request $request
     * @param User $author
     * @return JsonResponse
     */
    public function destroy(Request $request, User $author): JsonResponse
    {
        $request->user()
            ->subscriptions()
            ->detach($author->id);

        return response()->json([
            'message' => 'Unsubscribed successfully.'
        ]);
    }
}
