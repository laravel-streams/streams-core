<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

/**
  * @param       $name
 * @param array $parameters
 * @param array $extra
 * @param null  $secure
 * @return string
 */
class UrlStreams
{
    public function __invoke()
    {
        return
            /**
                          * @param       $name
             * @param array $parameters
             * @param array $extra
             * @param null  $secure
             * @return string
             */ function ($name, $parameters = [], array $extra = [], $secure = null) {
            $parameters = Arr::make($parameters);

            $extra = $extra ? '?' . http_build_query($extra) : null;

            if ( ! $route = Route::getRoutes()->getByName($name)) {
                return URL::to(Str::parse($name, $parameters) . $extra, [], $secure);
            }

            $uri = $route->uri();

            foreach (array_keys($parameters) as $key) {
                $uri = str_replace("{{$key}__", "{{$key}.", $uri);
            }

            return URL::to(Str::parse($uri, $parameters) . $extra, [], $secure);
        };
    }

}
