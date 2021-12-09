<?php

namespace Streams\Core\Support\Macros;

use Streams\Core\Stream\StreamRouter;

/**
 * @param $uri
 * @param $route
 */
class RouteStreams
{
    public function __invoke()
    {
        return
            /**
             * @param $uri
             * @param $route
             */ function ($uri, $route) {
            StreamRouter::route($uri, $route);
        };
    }

}
