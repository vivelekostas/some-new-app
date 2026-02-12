<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected PostService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): PostCollection
    {
        return new PostCollection($this->service->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): PostResource
    {
        $this->authorize('create', Post::class);

        $post = $this->service->create(
            $request->user(),
            $request->validated()
        );

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): PostResource
    {
        $this->authorize('view', $post);

        $post->load(['user', 'category', 'comments.user']);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $this->authorize('update', $post);

        $post = $this->service->update(
            $post,
            $request->validated()
        );

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $this->service->delete($post);

        return response()->noContent();
    }
}
