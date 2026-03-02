<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagService
{
    /**
     * Возвращает список тегов для администрирования.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Tag::query()->latest()->get();
    }

    /**
     * Создаёт новый тег.
     *
     * @param array $data
     * @return Tag
     */
    public function create(array $data): Tag
    {
        return Tag::query()->create($data);
    }

    /**
     * Обновляет тег.
     *
     * @param Tag $tag
     * @param array $data
     * @return Tag
     */
    public function update(Tag $tag, array $data): Tag
    {
        $tag->update($data);

        return $tag;
    }

    /**
     * Удаляет тег.
     *
     * @param Tag $tag
     * @return void
     */
    public function delete(Tag $tag): void
    {
        $tag->delete();
    }
}
