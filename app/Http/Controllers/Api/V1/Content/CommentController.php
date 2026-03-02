<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected CommentService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return CommentCollection
     */
    public function index(): CommentCollection
    {
        $this->authorize('viewAny', Comment::class);

        return new CommentCollection($this->service->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCommentRequest $request
     * @param Post $post
     * @return CommentResource
     */
    public function store(StoreCommentRequest $request, Post $post): CommentResource
    {
        $this->authorize('create', Comment::class);

        $comment = $this->service->create(
            $post,
            $request->validated(),
            $request->user()->id
        );

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @param Comment $comment
     * @return CommentResource
     */
    public function show(Post $post, Comment $comment): CommentResource
    {
        $this->authorize('view', $comment);

        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest $request
     * @param Post $post
     * @param Comment $comment
     * @return CommentResource
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment): CommentResource
    {
        $this->authorize('update', $comment);

        $comment = $this->service->update($comment, $request->validated());

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $this->service->delete($comment);

        return response()->noContent();
    }
}
