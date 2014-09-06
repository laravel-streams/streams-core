<?php namespace Streams\Core\Facade;

use Illuminate\Support\Facades\Facade as BaseFacade;

class FieldTypeFacade extends BaseFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'streams.field_types';
    }
}
