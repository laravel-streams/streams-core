<?php

namespace Streams\Core\Support;

use ReflectionProperty;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Support\Traits\Prototype;

class Hydrator
{

    /**
     * Hydrate an object with parameters.
     *
     * @param $object
     * @param array $parameters
     * @return mixed
     */
    public function hydrate($object, array $parameters)
    {
        $classes = class_uses_recursive($object);

        $hasAttributes = in_array(Properties::class, $classes);

        foreach ($parameters as $parameter => $value) {

            $method = Str::camel('set_' . $parameter);

            if (method_exists($object, $method)) {
                $object->{$method}(Arr::pull($parameters, $parameter));
            }
        }

        if ($hasAttributes) {
            $object->setPrototypeAttributes($parameters);
        }

        return $object;
    }

    /**
     * Dehydrate an object.
     *
     * @param $object
     * @param array $except
     */
    public function dehydrate($object, array $except = [])
    {
        $attributes = [];

        $classes = class_uses_recursive($object);

        $reflection = new \ReflectionClass($object);

        $properties = array_merge(
            $reflection->getProperties(\ReflectionProperty::IS_PROTECTED),
            $reflection->getProperties(\ReflectionProperty::IS_PUBLIC)
        );

        $accessors = array_filter(
            array_combine(
                array_map(function (ReflectionProperty $property) {
                    return Str::snake($property->getName());
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

        $public = array_filter(
            array_combine(
                array_map(function (ReflectionProperty $property) {
                    return Str::snake($property->getName());
                }, $properties),
                array_map(function (ReflectionProperty $property) {
                    return $property->isPublic() ? $property->getName() : null;
                }, $properties)
            )
        );

        /**
         * Execute the methods.
         */
        array_walk($accessors, function (&$method) use ($object) {
            $method = $object->{$method}();
        });

        /**
         * Access the public attributes.
         */
        array_walk($public, function (&$attribute) use ($object) {
            $attribute = $object->{$attribute};
        });

        /**
         * Grab attributes last.
         */
        if (in_array(Prototype::class, $classes)) {
            $attributes = $object->getPrototypeAttributes();
        }

        return array_diff_key(array_flip($except), $attributes + $public + $accessors);
    }
}
