<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{
    /**
     * Ресурс, используемый при формировании коллекции.
     *
     * @var string
     */
    public $collects = CommentResource::class;
}
