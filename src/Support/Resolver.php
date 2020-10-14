<?php

namespace Streams\Core\Support;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

/**
 * Class Resolver
 *
 * This is a handy class for getting input from
 * a callable target.
 *
 * $someArrayConfig = 'MyCallableClass@handle'
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Resolver
{

    /**
     * Resolve the target.
     *
     * @param $target
     * @param array $arguments
     * @param array $options
     * @return mixed
     */
    public function resolve($target, array $arguments = [], array $options = [])
    {
        $method = Arr::get($options, 'method', 'handle');

        try {
            if (
                (is_string($target) && Str::contains($target, '@'))
                || is_callable($target)
            ) {
                return App::call($target, $arguments);
            }

            if (
                is_string($target)
                && class_exists($target)
                && method_exists($target, $method)
            ) {
                return App::call($target . '@' . $method, $arguments);
            }
        } catch (BindingResolutionException $e) {
            return null;
        }

        return null;
    }
}
