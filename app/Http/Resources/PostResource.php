<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Post
 */
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'body' => $this->body,
            'is_published' => $this->is_published,
            'user_name' => $this->whenLoaded(
                'user',
                fn() => $this->user->name
            ),
            'category_title' => $this->whenLoaded(
                'category',
                fn() => $this->category?->title,
            ),
            'comments' => new CommentCollection(
                $this->whenLoaded(
                    'comments'
                )
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
