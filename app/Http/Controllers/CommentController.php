<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function __construct(protected CommentService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CommentCollection($this->service->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = $this->service->create(
            $post,
            $request->validated(),
            $request->user()->id
        );

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Comment $comment)
    {
//        dd($comment);
        return new CommentResource($comment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        $this->service->update(
            $comment,
            $request->validated()
        );

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        $this->service->delete($comment);

        return response()->noContent();
    }
}
