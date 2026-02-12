<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        function sum(int $a, int $b): int
        {
            return $a + $b;
        }

        return sum(5, 10);
    }
}
