<?php

namespace Streams\Core\Addon;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Addon\Addon;
use Illuminate\Support\Collection;

/**
 * The addon collection contains all registered addons.
 */
class AddonCollection extends Collection
{

    protected string $vendor = '';

    public function core(): AddonCollection
    {
        $vendor = $this->vendorDirectory();

        return $this->filter(
            function (Addon $addon) use ($vendor) {
                return Str::startsWith($addon->path, $vendor);
            }
        );
    }

    public function nonCore(): AddonCollection
    {
        $vendor = $this->vendorDirectory();

        return $this->filter(
            function (Addon $addon) use ($vendor) {
                return !Str::startsWith($addon->path, $vendor);
            }
        );
    }

    protected function vendorDirectory(): string
    {
        if ($this->vendor) {
            return $this->vendor;
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        return $this->vendor = (string) Arr::get($composer, 'config.vendor-dir', base_path('vendor'));
    }
}
