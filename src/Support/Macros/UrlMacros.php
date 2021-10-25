<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

class UrlMacros
{

    static public function streams($name, $parameters = [], array $extra = [], $absolute = true)
    {
        $parameters = Arr::make($parameters);

        $extra = $extra ? '?' . http_build_query($extra) : null;

        if (!$route = Route::getByName($name)) {
            return URL::to(Str::parse($name, $parameters) . $extra, [], $absolute);
        }

        $uri = $route->uri();

        foreach (array_keys($parameters) as $key) {
            $uri = str_replace("{{$key}__", "{{$key}.", $uri);
        }

        return URL::to(Str::parse($uri, $parameters) . $extra, [], $absolute);
    }
}
