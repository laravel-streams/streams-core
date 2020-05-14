<?php

namespace Anomaly\Streams\Platform\Streams\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Streams
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Streams extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'streams';
    }
}
