<?php

namespace Streams\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Streams\Core\View\ViewIncludes include(string $slot, string $include)
 */
class Includes extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'includes';
    }
}
