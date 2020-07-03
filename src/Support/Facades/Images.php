<?php

namespace Anomaly\Streams\Platform\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Images
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Images extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'images';
    }
}
