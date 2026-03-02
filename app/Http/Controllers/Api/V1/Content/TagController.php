<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

class TagController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected TagService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return TagCollection
     */
    public function index(): TagCollection
    {
        $this->authorize('viewAny', Tag::class);

        return TagCollection::make($this->service->index());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return TagResource
     */
    public function store(TagRequest $request): TagResource
    {
        $this->authorize('create', Tag::class);

        $tag = $this->service->create($request->validated());

        return new TagResource($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param Tag $tag
     * @return TagResource
     */
    public function show(Tag $tag): TagResource
    {
        $this->authorize('view', $tag);

        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TagRequest $request
     * @param Tag $tag
     * @return TagResource
     */
    public function update (TagRequest $request, Tag $tag): TagResource
    {
        $this->authorize('edit', $tag);

        $tag = $this->service->update($tag, $request->validated());

        return new TagResource($tag);
    }

    /**
     * @param Tag $tag
     * @return Response
     */
    public function destroy(Tag $tag): Response
    {
        $this->authorize('delete', $tag);

        $this->service->delete($tag);

        return response()->noContent();
    }
}
