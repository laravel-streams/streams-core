<?php

namespace Streams\Core\Addon;

use Illuminate\Support\Str;
use Streams\Core\Addon\Addon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

/**
 * The addon collection contains all registered addons.
 */
class AddonCollection extends Collection
{

    // @todo are these even helpful? 
    // public function core(): AddonCollection
    // {
    //     $vendor = App::make('vendor.path');

    //     return $this->filter(
    //         function (Addon $addon) use ($vendor) {
    //             return Str::startsWith($addon->path, $vendor);
    //         }
    //     );
    // }

    // public function nonCore(): AddonCollection
    // {
    //     $vendor = App::make('vendor.path');

    //     return $this->filter(
    //         function (Addon $addon) use ($vendor) {
    //             return !Str::startsWith($addon->path, $vendor);
    //         }
    //     );
    // }
}
