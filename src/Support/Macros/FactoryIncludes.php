<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Facades\View;
use Streams\Core\Support\Facades\Includes;

class FactoryIncludes
{
    public function __invoke()
    {
        return function (string $slot, array $payload = [], string $glue = "\n"): string {
            return Includes::slot($slot)->map(function ($include) use ($payload) {
                return View::make($include, $payload)->render();
            })->implode($glue);
        };
    }
}
