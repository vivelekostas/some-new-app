<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected PostService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return PostCollection
     */
    public function index(): PostCollection
    {
        $this->authorize('viewAny', Post::class);

        return new PostCollection($this->service->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostRequest $request
     * @return PostResource
     */
    public function store(StorePostRequest $request): PostResource
    {
        $this->authorize('create', Post::class);

        $post = $this->service->create($request->user(), $request->validated());

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return PostResource
     */
    public function show(Post $post): PostResource
    {
        $this->authorize('view', $post);

        $post->load(['user', 'category', 'comments.user', 'tags']);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return PostResource
     */
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $this->authorize('update', $post);

        $post = $this->service->update($post, $request->validated());

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     */
    public function destroy(Post $post): Response
    {
        $this->authorize('delete', $post);

        $this->service->delete($post);

        return response()->noContent();
    }
}
