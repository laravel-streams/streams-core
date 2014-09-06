<?php namespace Streams\Core\Facade;

use Illuminate\Support\Facades\Facade as BaseFacade;

class ExtensionFacade extends BaseFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'streams.extensions';
    }
}
