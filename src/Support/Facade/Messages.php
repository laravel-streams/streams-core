<?php

use Anomaly\Streams\Platform\Message\MessageBag;
use Illuminate\Support\Facades\Facade;

/**
 * Class MessageBagFacade
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Messages extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MessageBag::class;
    }
}
