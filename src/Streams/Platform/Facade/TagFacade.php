<?php namespace Streams\Platform\Facade;

use Illuminate\Support\Facades\Facade as BaseFacade;

class TagFacade extends BaseFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'streams.tags';
    }

}
