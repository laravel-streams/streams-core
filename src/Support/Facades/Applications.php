<?php

namespace Streams\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Applications
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 *
 * @method static \Streams\Core\Application\Application make($handle = null)
 * @method static string active()
 * @method static \Streams\Core\Application\ApplicationManager switch($handle = null)
 */
class Applications extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'applications';
    }
}
