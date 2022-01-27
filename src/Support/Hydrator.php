<?php

namespace Streams\Core\Support;

use ReflectionProperty;
use Illuminate\Support\Str;
use Streams\Core\Support\Traits\Prototype;

/**
 * This utility makes it easy to extract all
 * accessible property values from a given object.
 * 
 * Property names are snake cased.
 * 
 * 
 * $data = Hydrator::dehydrate($object);
 * 
 * $value = $data['property_name'];
 *
 */
class Hydrator
{

    public function dehydrate($object, array $except = []): array
    {
        $attributes = [];

        $classes = class_uses_recursive($object);

        $reflection = new \ReflectionClass($object);

        $properties = array_merge(
            $reflection->getProperties(\ReflectionProperty::IS_PROTECTED),
            $reflection->getProperties(\ReflectionProperty::IS_PUBLIC),
        );

        $accessors = array_combine(
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
        );

        $typed = array_filter(
            array_combine(
                array_map(function (ReflectionProperty $property) {
                    return Str::snake($property->getName());
                }, $properties),
                array_map(function (ReflectionProperty $property) {
                    return ($type = $property->getType()) ? $type->getName() : null;
                }, $properties)
            )
        );

        $public = array_combine(
            array_map(function (ReflectionProperty $property) {
                return Str::snake($property->getName());
            }, $properties),
            array_map(function (ReflectionProperty $property) {
                return $property->isPublic() ? $property->getName() : null;
            }, $properties)
        );

        $nonStatic = array_keys(get_object_vars($object));

        $public = array_merge($public, array_combine(array_map(function($name) {
            return Str::snake($name);
        }, $nonStatic), $nonStatic));

        $public = array_filter($public);
        $accessors = array_filter($accessors);

        /**
         * Execute the methods.
         */
        array_walk($accessors, function (&$method) use ($object) {
            $method = $object->{$method}();
        });

        /**
         * Access the public attributes.
         */
        array_walk($public, function (&$attribute) use ($typed, $object) {
            
            /**
             * If the property is typed but not
             * initialized then skip it entirely.
             */
            if (isset($typed[$attribute]) && !isset($object->{$attribute})) {
                return;
            }

            $attribute = $object->{$attribute};
        });

        /**
         * Grab attributes last.
         */
        if (in_array(Prototype::class, $classes)) {
            $attributes = $object->getPrototypeAttributes();
        }

        return array_diff_key($attributes + $public + $accessors, array_flip($except));
    }
}
