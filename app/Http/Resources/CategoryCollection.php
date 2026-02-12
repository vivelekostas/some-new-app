<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Ресурс, используемый при формировании коллекции.
     *
     * @var string
     */
    public $collects = CategoryResource::class;
}
