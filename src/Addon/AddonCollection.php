<?php

namespace Streams\Core\Addon;

use Exception;
use Illuminate\Support\Str;
use Streams\Core\Addon\Addon;
use Illuminate\Support\Collection;

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
            function (Addon $addon) {
                return Str::startsWith($addon->path, base_path('vendor'));
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
            function (Addon $addon) {
                return !Str::startsWith($addon->path, base_path('vendor'));
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
            function (Addon $addon) {
                return $addon->enabled;
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
            function (Addon $addon) {
                return !$addon->enabled;
            }
        );
    }
}
