<?php namespace Streams\Core\Facade;

use Illuminate\Support\Facades\Facade as BaseFacade;

class ArrayHelperFacade extends BaseFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'array.helper';
    }
}
