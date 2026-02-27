<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function getForDashboard(User $user): Collection|\Illuminate\Support\Collection
    {
        if (! $user->hasRole('admin')) {
            return collect(); // пустая коллекция
        }

        return Category::query()->latest()->get();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Category::query()
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Category
    {
        return Category::query()->create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->refresh();
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
