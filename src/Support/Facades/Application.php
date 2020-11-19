<?php

namespace Streams\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Application
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 *
 * @method static \Streams\Core\Application\ApplicationManager make($handle = null)
 * @method static \Streams\Core\Application\ApplicationManager handle()
 * @method static \Streams\Core\Application\ApplicationManager switch($handle = null)
 */
class Application extends Facade
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
