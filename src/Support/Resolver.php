<?php

namespace Anomaly\Streams\Platform\Support;

use Exception;

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
     * @todo should this be wrapped in a try catch to prevent a ReflectionException?
     *
     * @param $target
     * @param array $arguments
     * @param array $options
     * @return mixed
     */
    public function resolve($target, array $arguments = [], array $options = [])
    {
        $method = array_get($options, 'method', 'handle');

        if (
            (is_string($target) && str_contains($target, '@'))
            || is_callable($target)
        ) {
            return app()->call($target, $arguments);
        }

        if (
            is_string($target)
            && class_exists($target)
            && method_exists($target, $method)
        ) {
            return app()->call($target . '@' . $method, $arguments);
        }

        return null;
    }
}
