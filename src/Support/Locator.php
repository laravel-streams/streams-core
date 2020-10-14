<?php

namespace Streams\Core\Support;

use Illuminate\Support\Str;

/**
 * Class Locator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Locator
{

    /**
     * Locate the addon containing an object.
     * Returns the addon's dot namespace.
     *
     * @param $object
     * @return null|string
     */
    public function locate($object)
    {
        if (
            is_object($object)
            && ($object::hasMacro('__locate') || method_exists($object, '__locate'))
        ) {
            return $object->__locate();
        }

        $class = explode('\\', is_string($object) ? $object : get_class($object));

        $vendor = Str::snake(array_shift($class));
        $addon  = Str::snake(array_shift($class));

        if (!preg_match('/(?!_)module$|(?!_)extension$|(?!_)field_type$|(?!_)theme$/', $addon, $type)) {
            return null;
        }

        $addon = preg_replace('/_module$|_extension$|_field_type$|_theme$/', '', $addon);

        $namespace = "{$vendor}.{$type[0]}.{$addon}";

        return app('streams.addons')->offsetExists($namespace) ? $namespace : null;
    }

    /**
     * Return the located addon instance.
     *
     * @param $object
     * @return \Streams\Core\Addon\Addon|mixed|null
     */
    public static function resolve($object)
    {
        if (!$namespace = self::locate($object)) {
            return null;
        }

        return app('streams.addons')->instance($namespace);
    }
}
