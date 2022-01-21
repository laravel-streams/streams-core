<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

class StreamRouter
{

    static public function route($uri, $route)
    {

        /**
         * Replace deep entry attributes with
         * something we can reference later.
         */
        $uri = str_replace('entry.', 'entry__', $uri);

        /**
         * If the route is a controller...
         */
        if (is_string($route) && strpos($route, '@')) {
            $route = [
                'uses' => $route,
            ];
        }

        /**
         * Assume the route is a view otherwise.
         */
        if (is_string($route) && !strpos($route, '@')) {
            $route = [
                'view' => $route,
                'uses' => '\Streams\Core\Http\Controller\StreamsController@handle',
            ];
        }

        /**
         * Ensure something is
         * handling the request.
         */
        if (!isset($route['uses'])) {
            $route['uses'] = '\Streams\Core\Http\Controller\StreamsController@handle';
        }

        /**
         * Pull out route options. What's left
         * is passed in as route action data.
         */
        $csrf        = Arr::pull($route, 'csrf');
        $verb        = Arr::pull($route, 'verb', 'any');
        $middleware  = Arr::pull($route, 'middleware', []);
        $constraints = Arr::pull($route, 'constraints', []);

        /**
         * Ensure some default
         * information is present.
         */
        if (!isset($route['uses'])) {
            $route['uses'] = 'Streams\Core\Http\Controller\StreamsController@handle';
        }

        /**
         * If the route contains a
         * controller@action then
         * create a normal route.
         * -----------------------
         * If the route does NOT
         * contain an action then
         * treat it as a resource.
         */
        $route = Route::{$verb}($uri, $route); // includes Single action controllers
        // if (str_contains($route['uses'], '@')) {
        //     $route = Route::{$verb}($uri, $route);
        // } else {
        //     $route = Route::resource($uri, $route['uses']); // Need flag
        // }

        /**
         * Call constraints if
         * any are provided.
         */
        if ($constraints) {
            call_user_func_array([$route, 'where'], (array) $constraints);
        }

        /**
         * Call middleware if
         * any are provided.
         */
        if ($middleware) {
            call_user_func_array([$route, 'middleware'], (array) $middleware);
        }

        /**
         * Disable CSRF
         */
        if ($csrf === false) {
            call_user_func_array([$route, 'withoutMiddleware'], ['csrf']);
        }
    }
}
