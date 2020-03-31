<?php

namespace Anomaly\Streams\Platform\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Locator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Locator extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'locator';
    }
}
