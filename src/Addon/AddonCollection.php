<?php

namespace Streams\Core\Addon;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

/**
 * Class AddonCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonCollection extends Collection
{

    /**
     * Return only core addons.
     *
     * @return AddonCollection
     */
    public function core()
    {
        return $this->filter(
            function (array $addon) {
                return is_dir(base_path('vendor/' . $addon['name']));
            }
        );
    }

    /**
     * Return only non-core addons.
     *
     * @return AddonCollection
     */
    public function nonCore()
    {
        return $this->filter(
            function (array $addon) {
                return !is_dir(base_path('vendor/' . $addon['name']));
            }
        );
    }

    /**
     * Return enabled addons.
     *
     * @return AddonCollection
     */
    public function enabled()
    {
        return $this->filter(
            function (array $addon) {
                return Arr::get($addon, 'enabled');
            }
        );
    }

    /**
     * Return disabled addons.
     *
     * @return AddonCollection
     */
    public function disabled()
    {
        return $this->filter(
            function (array $addon) {
                return Arr::get($addon, 'enabled') == false;
            }
        );
    }

    /**
     * Call a method.
     *
     * @param $method
     * @param $arguments
     * @return AddonCollection
     */
    public function __call($method, $arguments)
    {
        $type = Str::singular(Str::snake($method));

        if (in_array($type, [
            'field_type',
            'extension',
            'module',
            'theme',
        ])) {
            return app("{$type}.collection");
        }

        throw new Exception("Method [{$method}] does not exist.");
    }

    /**
     * Get a property.
     *
     * @param $name
     * @return AddonCollection
     */
    public function __get($name)
    {
        $type = Str::singular($name);

        if (in_array($type, [
            'field_type',
            'extension',
            'module',
            'theme',
        ])) {
            return app("{$type}.collection");
        }

        return parent::get($name);
    }
}
