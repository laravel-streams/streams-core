<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

class UrlStreams
{
    public function __invoke()
    {
        return function (string $name, array|Arrayable $parameters = [], array $extra = [], bool|null $secure = null) {

            $parameters = Arr::make($parameters);

            $extra = $extra ? '?' . http_build_query($extra) : null;

            if (!$route = Route::getRoutes()->getByName($name)) {
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
