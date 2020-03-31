<?php

namespace Anomaly\Streams\Platform\Asset\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Assets
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Assets extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'assets';
    }
}
