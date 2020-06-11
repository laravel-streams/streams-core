<?php

namespace Anomaly\Streams\Platform\Support;

use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Traits\Hookable;
use Anomaly\Streams\Platform\Addon\AddonCollection;

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
            && in_array(Hookable::class, class_uses_recursive($object))
            && ($object->hasHook('__locate') || method_exists($object, '__locate'))
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

        return app('addon.collection')->offsetExists($namespace) ? $namespace : null;
    }

    /**
     * Return the located addon instance.
     *
     * @param $object
     * @return \Anomaly\Streams\Platform\Addon\Addon|mixed|null
     */
    public static function resolve($object)
    {
        if (!$namespace = self::locate($object)) {
            return null;
        }

        return app('addon.collection')->instance($namespace);
    }
}
