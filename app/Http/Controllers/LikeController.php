<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likePost(Post $post): JsonResponse
    {
        $post->likes()->firstOrCreate([
            'user_id' => auth()->id()
        ]);

        return response()->json(['message' => 'Liked']);
    }

    public function unlikePost(Post $post): JsonResponse
    {
        $post->likes()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json(['message' => 'Unliked']);
    }

    public function likeComment(Comment $comment): JsonResponse
    {
        $comment->likes()->firstOrCreate([
            'user_id' => auth()->id()
        ]);

        return response()->json(['message' => 'Liked']);
    }

    public function unlikeComment(Comment $comment): JsonResponse
    {
        $comment->likes()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json(['message' => 'Unliked']);
    }

}
