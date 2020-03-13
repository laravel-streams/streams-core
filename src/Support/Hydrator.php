<?php

namespace Anomaly\Streams\Platform\Support;

use ReflectionProperty;

/**
 * Class Hydrator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Hydrator
{

    /**
     * Hydrate an object with parameters.
     *
     * @param $object
     * @param array $parameters
     * @return mixed
     */
    public static function hydrate($object, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {
            $method = camel_case('set_' . $parameter);

            if (method_exists($object, $method)) {
                $object->{$method}($value);
            }
        }

        return $object;
    }

    /**
     * Dehydrate an object.
     *
     * @param array $object
     */
    public static function dehydrate($object)
    {
        $reflection = new \ReflectionClass($object);

        $properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);

        $accessors = array_filter(
            array_combine(
                array_map(function (ReflectionProperty $property) {
                    return snake_case($property->getName());
                }, $properties),
                array_map(function (ReflectionProperty $property) use ($object) {

                    if (method_exists($object, $method = 'get' . ucfirst($property->getName()))) {
                        return $method;
                    }

                    if (method_exists($object, $method = 'is' . ucfirst($property->getName()))) {
                        return $method;
                    }

                    return null;
                }, $properties)
            )
        );

        /**
         * Execute the methods.
         */
        array_walk($accessors, function (&$method) use ($object) {
            $method = $object->{$method}();
        });

        return $accessors;
    }
}
