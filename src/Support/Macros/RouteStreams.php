<?php

namespace Streams\Core\Support\Macros;

use Streams\Core\Stream\StreamRouter;

class RouteStreams
{
    public function __invoke()
    {
        return function (string $uri, string|array $route): void {
            StreamRouter::route($uri, $route);
        };
    }
}
