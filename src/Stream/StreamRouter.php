<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Route as RouteInstance;

class StreamRouter
{
    public static function route(string $uri, string|array $route): RouteInstance
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
        if (is_string($route) && ! strpos($route, '@')) {
            $route = [
                'view' => $route,
                'uses' => '\Streams\Core\Http\Controller\EntryController',
            ];
        }

        /**
         * Ensure something is
         * handling the request.
         */
        if (! isset($route['uses'])) {
            $route['uses'] = '\Streams\Core\Http\Controller\EntryController';
        }

        /**
         * Pull out route options. What's left
         * is passed in as route action data.
         */
        $csrf = Arr::pull($route, 'csrf');
        $verb = Arr::pull($route, 'verb', 'any');
        $middleware = Arr::pull($route, 'middleware', []);
        $constraints = Arr::pull($route, 'constraints', []);

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

        /**
         * Call constraints if
         * any are provided.
         */
        if ($constraints = static::normalizeConstraints($constraints)) {
            $route->where($constraints);
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

        return $route;
    }

    /**
     * Normalize route constraints into a
     * [parameter => pattern] map for Route::where().
     *
     * Accepted shapes:
     *  - a map:                {"id": "[0-9]+", "slug": "[a-z-]+"}
     *  - a list of maps:       [{"id": "[0-9]+"}, {"slug": "[a-z-]+"}]
     *  - a [name, pattern] pair (legacy positional form): ["id", "[0-9]+"]
     *  - a list of pairs:      [["id", "[0-9]+"], ["slug", "[a-z-]+"]]
     *
     * Passing a map straight to call_user_func_array() made PHP 8 treat
     * its keys as named arguments ("Unknown named parameter"), and a list
     * of maps only applied the first one. Everything is merged here instead.
     */
    public static function normalizeConstraints(mixed $constraints): array
    {
        if ($constraints instanceof \Illuminate\Contracts\Support\Arrayable) {
            $constraints = $constraints->toArray();
        }

        if (is_object($constraints)) {
            $constraints = get_object_vars($constraints);
        }

        if (! is_array($constraints) || $constraints === []) {
            return [];
        }

        if (static::isConstraintPair($constraints)) {
            return [$constraints[0] => $constraints[1]];
        }

        if (! array_is_list($constraints)) {
            return array_map('strval', array_filter(
                $constraints,
                fn ($pattern, $name) => is_string($name) && is_scalar($pattern),
                ARRAY_FILTER_USE_BOTH
            ));
        }

        $normalized = [];

        foreach ($constraints as $constraint) {
            $normalized = array_merge($normalized, static::normalizeConstraints($constraint));
        }

        return $normalized;
    }

    protected static function isConstraintPair(array $constraints): bool
    {
        return array_is_list($constraints)
            && count($constraints) === 2
            && is_string($constraints[0])
            && is_string($constraints[1]);
    }
}
